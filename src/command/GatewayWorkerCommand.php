<?php
namespace gumphp\gatewayworker\command;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use Workerman\Worker;

class GatewayWorkerCommand extends Command
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @var string
     */
    protected string $action = 'start';

    /**
     * @var bool
     */
    protected bool $daemon;

    protected function initialize(Input $input, Output $output)
    {
        $this->config = config('gatewayworker');
        $this->action = $input->getArgument('action');
        $this->daemon = $input->hasOption('daemon');
        parent::initialize($input, $output);
    }

    protected function configure()
    {
        $this->setName('gumphp:gatewayworker')
            ->setDescription('GatewayWorker Command')
            ->addArgument('action', Argument::OPTIONAL, 'start|stop|restart|reload|status', 'start')
            ->addOption('daemon', 'd', Option::VALUE_OPTIONAL, 'Run the gateway worker in daemon mode', true)
        ;
    }

    protected function execute(Input $input, Output $output)
    {
        $this->startRegister();
        $this->startGateway();
        $this->startBusinessWorker();
        Worker::runAll();
    }

    /**
     * https://www.workerman.net/doc/gateway-worker/register.html
     * @return void
     */
    protected function startRegister()
    {
        $worker = new Register('text://0.0.0.0:1238');
    }

    /**
     * https://www.workerman.net/doc/gateway-worker/gateway.html
     * @return void
     */
    protected function startGateway()
    {
        $worker = new Gateway('ws://0.0.0.0:8282');
        // gateway名称，status方便查看
//        $worker->name = 'Gateway';
        // gateway进程数
        $worker->count = 4;
        // 本机ip，分布式部署时使用内网ip
        $worker->lanIp = '127.0.0.1';
        // 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
        // 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
        $worker->startPort = 2900;
        // 服务注册地址
        $worker->registerAddress = '127.0.0.1:1238';
    }

    /**
     * https://www.workerman.net/doc/gateway-worker/business-worker.html
     * @return void
     */
    protected function startBusinessWorker()
    {
        $worker = new BusinessWorker();
        // worker名称
        $worker->name = 'BusinessWorker';
        // bussinessWorker进程数量
        $worker->count = 4;
        // 服务注册地址
        $worker->registerAddress = '127.0.0.1:1238';
        // 设置处理业务的类
        $worker->eventHandler = \gumphp\gatewayworker\handler\Events::class;
    }
}
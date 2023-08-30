<?php
namespace gumphp\gatewayworker\command;

use gumphp\gatewayworker\GatewayWorker;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use Workerman\Worker;

class GatewayWorkerCommand extends Command
{
    protected function configure()
    {
        $this->setName('gumphp:gatewayworker')
            ->setDescription('GatewayWorker Command')
            ->addArgument('app', Argument::REQUIRED, 'app name')
            ->addArgument('action', Argument::OPTIONAL, 'start|stop|restart|reload|status', 'start')
            ->addOption('daemon', 'd', Option::VALUE_OPTIONAL, 'Run the gateway worker in daemon mode', true)
        ;
    }

    protected function execute(Input $input, Output $output)
    {
        global $argv;

        if (!in_array($action = $input->getArgument('action'), ['status', 'start', 'stop', 'restart', 'reload', 'connections'])) {
            $output->error('Invalid Arguments');
            return;
        }
        $appName = $input->getArgument('app');
        $daemon = $input->hasOption('d') ? '-d' : '';
        $argv[0] = 'gatewayworker ' . $appName;
        $argv[1] = $action;
        $argv[2] = $daemon;
        try {
            GatewayWorker::startAll($appName);
        } catch (\Exception $e) {
            $output->error($e->getMessage());
        }
    }
}
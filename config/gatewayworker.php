<?php
return [

    'default' => 'admin',

    'providers' => [
        'admin' => [
            'lan_ip' => env('ADMIN_LAN_IP', '127.0.0.1'), #内网ip,多服务器分布式部署的时候需要填写真实的内网ip

            'register' => env('ADMIN_REGISTER', 'text://0.0.0.0:1238'),
            'register_name' => 'AdminRegister',
            'register_address' => env('ADMIN_REGISTER_ADDRESS', '127.0.0.1:1238'), #注册服务地址

            'worker_name' => 'AdminBusinessWorker', #设置 BusinessWorker 进程的名称
            'worker_count' => 4, #设置 BusinessWorker 进程的数量
            # 设置使用哪个类来处理业务,业务类至少要实现onMessage静态方法，onConnect 和 onClose 静态方法可以不用实现
            'event_handler' => \gumphp\gatewayworker\handler\Events::class,

            'gateway' => env('ADMIN_GATEWAY', 'websocket://0.0.0.0:8282'),# 允许连接服务的地址
            'gateway_name' => 'AdminGateway', #设置 Gateway 进程的名称，方便status命令中查看统计
            'gateway_count' => 4, # Gateway 进程的数量
            'start_port' => env('ADMIN_START_PORT', '8292'),  #监听本机端口的起始端口
            'ping_interval' => 5,  # 心跳间隔时间，只针对服务端发送心跳
            'ping_not_response_limit' => 0,   # 0 服务端主动发送心跳, 1 客户端主动发送心跳
            'ping_data' => '{"type":"ping"}', # 服务端主动发送心跳的数据，只针对服务端发送心跳,客户端超时未发送心跳时会主动向客户端发送一次心跳检测

            'gateway_start' => true,
            'business_worker_start' => true,
            'register_start' => true,

            'gateway_transport' => 'tcp', // 当为 ssl 时，开启SSL，websocket+SSL 即 wss
            /*'gateway_context' => [
                // 更多ssl选项请参考手册 http://php.net/manual/zh/context.ssl.php
                'ssl' => array(
                    // 请使用绝对路径
                    'local_cert' => '/your/path/of/server.pem', // 也可以是crt文件
                    'local_pk' => '/your/path/of/server.key',
                    'verify_peer' => false,
                    'allow_self_signed' => true, //如果是自签名证书需要开启此选项
                )
            ],*/

            'pid_file' => null, // 自定义pid文件绝对路径，默认在vendor/smileymrking/laravel-gateway-worker/src/GatewayWorker/worker目录下
            'log_file' => null, // 自定义日志文件绝对路径，默认同上
        ],
        'index' => [
            'lan_ip' => env('INDEX_LAN_IP', '127.0.0.1'), #内网ip,多服务器分布式部署的时候需要填写真实的内网ip

            'register' => env('INDEX_REGISTER', 'text://0.0.0.0:1258'),
            'register_name' => 'IndexRegister',
            'register_address' => env('INDEX_REGISTER_ADDRESS', '127.0.0.1:1258'), #注册服务地址

            'worker_name' => 'IndexBusinessWorker', #设置 BusinessWorker 进程的名称
            'worker_count' => 4, #设置 BusinessWorker 进程的数量
            # 设置使用哪个类来处理业务,业务类至少要实现onMessage静态方法，onConnect 和 onClose 静态方法可以不用实现
            'event_handler' => \gumphp\gatewayworker\handler\Events::class,

            'gateway' => env('INDEX_GATEWAY', 'websocket://0.0.0.0:7272'),# 允许连接服务的地址
            'gateway_name' => 'IndexGateway', #设置 Gateway 进程的名称，方便status命令中查看统计
            'gateway_count' => 4, # Gateway 进程的数量
            'start_port' => env('INDEX_START_PORT', '7282'),  #监听本机端口的起始端口
            'ping_interval' => 3,  # 心跳间隔时间，只针对服务端发送心跳
            'ping_not_response_limit' => 0,   # 0 服务端主动发送心跳, 1 客户端主动发送心跳
            'ping_data' => '{"type":"ping", "data":{ "datetime": "' . date('Y-m-d H:i:s') . '"}}', # 服务端主动发送心跳的数据，只针对服务端发送心跳,客户端超时未发送心跳时会主动向客户端发送一次心跳检测

            'gateway_start' => true,
            'business_worker_start' => true,
            'register_start' => true,

            'gateway_transport' => 'tcp', // 当为 ssl 时，开启SSL，websocket+SSL 即 wss
            /*'gateway_context' => [
                // 更多ssl选项请参考手册 http://php.net/manual/zh/context.ssl.php
                'ssl' => array(
                    // 请使用绝对路径
                    'local_cert' => '/your/path/of/server.pem', // 也可以是crt文件
                    'local_pk' => '/your/path/of/server.key',
                    'verify_peer' => false,
                    'allow_self_signed' => true, //如果是自签名证书需要开启此选项
                )
            ],*/

            'pid_file' => null, // 自定义pid文件绝对路径，默认在vendor/smileymrking/laravel-gateway-worker/src/GatewayWorker/worker目录下
            'log_file' => null, // 自定义日志文件绝对路径，默认同上
        ],
    ],
];

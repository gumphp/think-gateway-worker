<?php
namespace gumphp\gatewayworker\service;

use think\Service;

class GatewayWorkerService extends Service
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->commands([
            \gumphp\gatewayworker\command\GatewayWorkerCommand::class,
        ]);
    }
}
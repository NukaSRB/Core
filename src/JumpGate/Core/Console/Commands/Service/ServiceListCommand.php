<?php

namespace JumpGate\Core\Console\Commands\Service;

class ServiceListCommand extends ServiceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all currently registered services.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = $this->getConfig();

        $headers = ['Name', 'Namespace', 'Path'];

        $rows = $config->map(function ($service) {
            return [
                $service->name,
                $service->namespace,
                $service->path,
            ];
        })->toArray();

        $this->table($headers, $rows);
    }
}

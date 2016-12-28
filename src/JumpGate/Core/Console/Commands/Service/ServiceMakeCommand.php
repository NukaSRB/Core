<?php

namespace JumpGate\Core\Console\Commands\Service;

use Illuminate\Support\Str;

class ServiceMakeCommand extends ServiceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service
                            {name : The name for the micro-service (This will be used for the folder name)}
                            {--no-folders : Stop the command from creating the default folders.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new micro-service for your application.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Set up the name and get the existing services.
        $name   = $this->getServiceName();
        $config = $this->getConfig();

        // Make sure we haven't already added the service.
        $this->checkForService($config, $name);

        // Add the service to the config.
        $config->push($this->generateService($name));

        // Add any directories that don't exist but need to.
        $this->makeDirectory($config->last());

        // Overwrite the services config with the new service added.
        $this->updateConfig($config);
    }

    /**
     * If the service is already in the config, exit immediately.
     *
     * @param $config
     * @param $name
     */
    private function checkForService($config, $name)
    {
        if ($config->keyBy('name')->has($name)) {
            $this->error('Service already exists with name "' . $name . '".');
            die;
        }
    }

    /**
     * Structure the new service correctly for the config.
     *
     * @param $name
     *
     * @return object
     */
    public function generateService($name)
    {
        return (object)[
            'name'      => $name,
            'lower'     => Str::snake($this->argument('name'), '-'),
            'namespace' => 'App\Services\\' . $name,
            'path'      => 'app/Services/' . $name,
        ];
    }

    /**
     * Make any directories that need to exist for this service.
     *
     * @param $service
     */
    private function makeDirectory($service)
    {
        if (! $this->files->exists($service->path)) {
            $this->files->makeDirectory($service->path, 0755, true);
        }

        if (! $this->option('no-folders')) {
            $this->files->makeDirectory($service->path . '/Http/Controllers', 0755, true);
            $this->files->makeDirectory($service->path . '/Http/Routes', 0755, true);
            $this->files->makeDirectory($service->path . '/Models', 0755, true);
        }
    }
}

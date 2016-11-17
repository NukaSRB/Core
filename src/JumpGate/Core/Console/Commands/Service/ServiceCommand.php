<?php

namespace JumpGate\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class ServiceCommand extends Command
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $configLocation;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files          = $files;
        $this->configLocation = base_path('bootstrap/services.json');
    }

    /**
     * Convert the given name to one used by the system.
     *
     * @param null $name
     *
     * @return string
     */
    protected function getServiceName($name = null)
    {
        $name = is_null($name) ? $this->argument('name') : $name;

        return Str::studly($name);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getConfig()
    {
        return collect(
            json_decode(
                $this->files->get($this->configLocation)
            )
        );
    }

    /**
     * Replace the contents of the config.
     *
     * @param $config
     */
    protected function updateConfig($config)
    {
        $this->files->put($this->configLocation, json_encode($config, JSON_PRETTY_PRINT));
    }

    /**
     * Replace the contents of a stub with proper names.
     *
     * @param $stub
     * @param $service
     * @param $class
     *
     * @return mixed
     */
    protected function updateStubContents($stub, $service, $class)
    {
        $search  = [
            'NAMESPACE',
            'CLASS',
            'LOWER_SERVICE',
            'LOWER_NAME',
        ];

        $replace = [
            $service->namespace,
            $class,
            $service->lower,
            Str::lower($class),
        ];

        return str_replace($search, $replace, $stub);
    }
}

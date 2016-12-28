<?php

namespace JumpGate\Core\Console\Commands\Service;

class ServiceScaffoldCommand extends ServiceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:scaffold
                            {name : The name of the service these will go into.}
                            {controller : The name of the controller being added.}
                            {--single-action : The controller will only have an __invoke method.}
                            {--crud : The controller will have all 7 common CRUD methods.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller and routes in a service.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name       = $this->getServiceName();
        $config     = $this->getConfig();
        $service    = $config->keyBy('name')->get($name);
        $controller = $this->getServiceName($this->argument('controller'));

        // Make sure the service is registered.
        if (is_null($service)) {
            return $this->error('No service found with a name of "' . $name . '".  Use make:service to create it.');
        }

        // Add the files.
        $this->handleController($service, $controller);
        $this->handleRoute($service, $controller);

        // Add the new route to the service's list.
        $service = $this->addNewRoute($service, $controller);

        // Update the config.
        $config->put($config->search($service), $service);

        $this->updateConfig($config);

        $this->comment('Scaffold complete.');
    }

    private function handleController($service, $controller)
    {
        $controllerPath = $service->path . '/Http/Controllers/';
        $controllerFile = $controllerPath . $controller . '.php';

        // See if we already have a controller.
        if ($this->files->exists($controllerFile)) {
            return $this->error('Controller already exists at "' . $controllerFile . '".  Skipping...');
        }

        // Add the controller directory if needed.
        if (! $this->files->exists($controllerPath)) {
            $this->files->makeDirectory($controllerPath, 0755, true);
        }

        // Get the base controller contents.
        $controllerStub = 'ControllerDefault.stub';

        if ($this->option('single-action')) {
            $controllerStub = 'ControllerSingleAction.stub';
        }

        if ($this->option('crud')) {
            $controllerStub = 'ControllerCrud.stub';
        }

        $controllerContents = $this->files->get(__DIR__ . '/stubs/' . $controllerStub);
        $stub               = $this->updateStubContents($controllerContents, $service, $controller);

        // Add the controller.
        $this->files->put($controllerFile, $stub);
    }

    private function handleRoute($service, $controller)
    {
        $routePath = $service->path . '/Http/Routes/';
        $routeFile = $routePath . $controller . '.php';

        // See if we already have a route file.
        if ($this->files->exists($routeFile)) {
            return $this->error('Route class already exists at "' . $routeFile . '".  Skipping...');
        }

        // Add the route directory if needed.
        if (! $this->files->exists($routePath)) {
            $this->files->makeDirectory($routePath, 0755, true);
        }

        // Get the base route contents.
        $routeStub = 'RouteDefault.stub';

        if ($this->option('single-action')) {
            $routeStub = 'RouteSingleAction.stub';
        }

        if ($this->option('crud')) {
            $routeStub = 'RouteCrud.stub';
        }

        $routeContents = $this->files->get(__DIR__ . '/stubs/' . $routeStub);
        $stub = $this->updateStubContents($routeContents, $service, $controller);

        // Add the route.
        $this->files->put($routeFile, $stub);
    }

    /**
     * @param $service
     * @param $controller
     */
    private function addNewRoute($service, $controller)
    {
        $routes = isset($service->routes) ? collect($service->routes) : collect();
        $routes->push('\\' . $service->namespace . '\Http\Routes\\' . $controller);

        $service->routes = $routes->unique()->toArray();

        return $service;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-service {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a service for a specific module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module'); // Get the module name
        $name = $this->argument('name'); // Get the service name

        $modulePath = base_path("Modules/{$module}");
        $servicePath = "{$modulePath}/Services";

        // Check if the module exists
        if (!File::exists($modulePath)) {
            $this->error("Module '{$module}' does not exist.");
            return;
        }

        // Create the Services directory if it doesn't exist
        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath, 0755, true);
        }

        // Generate the service file
        $serviceFile = "{$servicePath}/{$name}Service.php";
        if (File::exists($serviceFile)) {
            $this->error("Service already exists: {$serviceFile}");
        } else {
            File::put($serviceFile, $this->getServiceStub($name, $module));
            $this->info("Service created: {$serviceFile}");
        }
    }

    /**
     * Get the stub for the service.
     */
    protected function getServiceStub($name, $module)
    {
        return <<<EOT
            <?php

            namespace Modules\\{$module}\\Services;

            use Modules\\{$module}\\Repositories\\{$name}Repository;

            class {$name}Service
            {
                protected \${$name}Repository;

                public function __construct({$name}Repository \${$name}Repository)
                {
                    \$this->{$name}Repository = \${$name}Repository;
                }

                // Add your service logic here
            }
            EOT;
    }
}
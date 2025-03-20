<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-repository {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository for a specific module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module'); // Get the module name
        $name = $this->argument('name'); // Get the repository name

        $modulePath = base_path("Modules/{$module}");
        $repositoryPath = "{$modulePath}/Repositories";

        // Check if the module exists
        if (!File::exists($modulePath)) {
            $this->error("Module '{$module}' does not exist.");
            return;
        }

        // Create the Repositories directory if it doesn't exist
        if (!File::exists($repositoryPath)) {
            File::makeDirectory($repositoryPath, 0755, true);
        }

        // Generate the repository file
        $repositoryFile = "{$repositoryPath}/{$name}Repository.php";
        if (File::exists($repositoryFile)) {
            $this->error("Repository already exists: {$repositoryFile}");
        } else {
            File::put($repositoryFile, $this->getRepositoryStub($name, $module));
            $this->info("Repository created: {$repositoryFile}");
        }
    }

    /**
     * Get the stub for the repository.
     */
    protected function getRepositoryStub($name, $module)
    {
        return <<<EOT
            <?php

            namespace Modules\\{$module}\\Repositories;

            class {$name}Repository
            {
                // Add your repository logic here
            }
            EOT;
    }
}
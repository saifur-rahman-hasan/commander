<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

class MakeService extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commander:make-service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'What is the service name?',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceName = $this->argument('name');
        $servicePath = $servicesRootDir = config('commander.service_path'). "/$serviceName";

        // Create the service directory if it doesn't exist
        $this->createDirectory($servicePath);

        // Create subdirectories inside the service directory
        $this->createSubDirectories($servicePath);

        // Check if the user wants to add CRUD operations
        $this->addCRUDOperations($serviceName, $servicePath);

        $this->info("Service structure created successfully for $serviceName");
    }

    private function createDirectory(string $directoryPath): void
    {
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
    }

    private function createSubDirectories(string $servicePath): void
    {
        $directories = $this->getServiceSubDirectories();

        foreach ($directories as $directory) {
            $subDirectoryPath = $servicePath . '/' . $directory;

            // Create the subdirectory if it doesn't exist
            $this->createDirectory($subDirectoryPath);

            $this->info("Created directory: $subDirectoryPath");
        }
    }


    private function addCRUDOperations(string $serviceName, string $servicePath): void
    {
        // Check if the user wants to add CRUD operations
        $choiceCRUD = $this->choice(
            'Do you want to add CRUD operation?',
            ['Yes', 'No'],
            0
        );

        if ($choiceCRUD === 'Yes') {
            // Copy and rename stub files to the respective directories
            $stubFiles = $this->getServiceCRUDOperationStubFiles();

            foreach ($stubFiles as $directory => $files) {
                foreach ($files as $stubFile) {
                    $this->copyAndRenameStubFile($stubFile, $directory, $serviceName, $servicePath);
                }
            }
        }
    }


    private function copyAndRenameStubFile(string $stubFile, string $directory, string $serviceName, string $servicePath): void
    {
        $stubFilePath = config('commander.stub_files_path') . "/$stubFile";
        $destinationPath = $servicePath . '/' . $directory . '/' . str_replace('Example', $serviceName, pathinfo($stubFile, PATHINFO_FILENAME)) . '.ts';

        // Copy the stub file to the service directory
        File::copy($stubFilePath, $destinationPath);

        // Replace placeholders in the copied file
        $this->replacePlaceholders($destinationPath, $serviceName);

        $this->info("Copied and renamed stub file: $destinationPath");
    }


    private function replacePlaceholders(string $filePath, string $serviceName): void
    {
        $content = File::get($filePath);

        // Replace placeholders with actual class names
        $content = str_replace('ExampleController', $serviceName . 'Controller', $content);

        // Save the modified content back to the file
        File::put($filePath, $content);
    }

    private function getServiceSubDirectories(): array
    {
        return [
            'Controllers',
            'Actions',
            'Repositories',
            'Interfaces'
        ];
    }

    private function getServiceCRUDOperationStubFiles(): array
    {
        return [
            'Controllers' => ['ExampleController.stub'],
            'Repositories' => ['ExampleRepository.stub'],
            'Interfaces' => ['ExampleInterface.stub'],
            'Actions' => ['ExampleAction.stub']
        ];
    }
}

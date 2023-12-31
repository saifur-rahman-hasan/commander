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
    protected $signature = 'commander:make-repository  {repository?} {--service=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Service Repository class';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $serviceName = $this->option('service');
        $repositoryName = $this->argument('repository');

        if (!$serviceName) {
            $serviceName = $this->askForServiceName();
        }

        if (!$repositoryName) {
            $repositoryName = $this->askForRepositoryName($serviceName);
        }

        $servicesRootDir = config('commander.service_path');
        $stubFilePath = config('commander.stub_files_path') . '/ExampleRepository.stub';

        if (!File::isFile($stubFilePath)) {
            $this->error("The stub file '{$stubFilePath}' does not exist.");
            return 0;
        }


        $servicePath = $servicesRootDir . '/' . $serviceName;
        $repositoryPath = $servicePath . "/Repositories";
        $repositoryFilePath = "${repositoryPath}/${repositoryName}.ts";

        if (!File::isDirectory($servicePath)) {
            $this->askForServiceCreationIfNotExists($servicePath);
        }

        if (!File::isDirectory($repositoryPath)) {
            File::makeDirectory($repositoryPath, 0755, true);
        }


        if (File::exists($repositoryFilePath)) {
            $this->error("The file '{$repositoryFilePath}' already exists. Please choose a different name.");
        } else {
            // Copy the stub file to the service directory
            File::copy($stubFilePath, $repositoryFilePath);

            $this->replaceRepositoryPlaceholders(
                $repositoryFilePath,
                $repositoryName
            );

            $this->info('Your repository has been created.');
            $this->line($repositoryFilePath);
            $this->newLine(1);

        }

    }

    private function replaceRepositoryPlaceholders(
        string $filePath,
        string $repositoryName
    ): void
    {
        $content = File::get($filePath);

        // Replace placeholders with actual class names
        $content = str_replace('ExampleRepository', $repositoryName, $content);

        // Save the modified content back to the file
        File::put($filePath, $content);
    }

    private function getServiceNameSuggestions(): array
    {
        return collect(File::directories(config('commander.service_path')))
            ->map(function ($directory) {
                return pathinfo($directory, PATHINFO_BASENAME);
            })->toArray();
    }

    private function askForServiceName()
    {
        return $this->anticipate(
            'What is the service name?',
            $this->getServiceNameSuggestions()
        );
    }

    private function askForRepositoryName($serviceName)
    {
        return $this->anticipate(
            'Enter the repository name',
            $this->getRepositoryNameSuggestions($serviceName)
        );
    }

    private function getRepositoryNameSuggestions($serviceName): array
    {
        return collect([$serviceName])
            ->map(function ($name) {
                return "${name}Repository";
            })->toArray();
    }

    private function askForServiceCreationIfNotExists($servicePath): void
    {
        $createService = $this->confirm(
            "The directory '{$servicePath}' does not exist. Do you want to create it?",
            'yes'
        );

        if (!$createService) {
            $this->info('repository creation canceled.');
            return;
        }

        // Create the service directory
        File::makeDirectory($servicePath, 0755, true);
    }
}

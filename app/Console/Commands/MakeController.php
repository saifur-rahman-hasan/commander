<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeController extends Command
{
    protected $signature = 'commander:make-controller {controller?} {--service=}';

    protected $description = 'Command description';

    public function handle()
    {
        $serviceName = $this->option('service');
        $controllerName = $this->argument('controller');

        if (!$serviceName) {
            $serviceName = $this->askForServiceName();
        }

        if (!$controllerName) {
            $controllerName = $this->askForControllerName($serviceName);
        }

        $servicesRootDir = config('commander.service_path');
        $stubFilePath = config('commander.stub_files_path') . '/ExampleController.stub';

        if (!File::isFile($stubFilePath)) {
            $this->error("The stub file '{$stubFilePath}' does not exist.");
            return 0;
        }


        $servicePath = $servicesRootDir . '/' . $serviceName;
        $controllerPath = $servicePath . "/Controllers";
        $controllerFilePath = "${controllerPath}/${controllerName}.ts";

        if (!File::isDirectory($servicePath)) {
            $this->askForServiceCreationIfNotExists($servicePath);
        }

        if (!File::isDirectory($controllerPath)) {
            File::makeDirectory($controllerPath, 0755, true);
        }


        if (File::exists($controllerFilePath)) {
            $this->error("The file '{$controllerFilePath}' already exists. Please choose a different name.");
        } else {
            // Copy the stub file to the service directory
            File::copy($stubFilePath, $controllerFilePath);

            $this->replaceControllerPlaceholders(
                $controllerFilePath,
                $controllerName
            );

            $this->info('Your controller has been created.');
            $this->line($controllerFilePath);
            $this->newLine(1);

        }
        return 0;
    }

    private function replaceControllerPlaceholders(
        string $filePath,
        string $controllerName
    ): void {
        $content = File::get($filePath);

        // Replace placeholders with actual class names
        $content = str_replace('ExampleController', $controllerName, $content);

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

    private function askForControllerName($serviceName)
    {
        return $this->anticipate(
            'Enter the controller name',
            $this->getControllerNameSuggestions($serviceName)
        );
    }

    private function getControllerNameSuggestions($serviceName): array
    {
        return collect([$serviceName])
            ->map(function ($name) {
                return "${name}Controller";
            })->toArray();
    }

    private function askForServiceCreationIfNotExists($servicePath): void
    {
        $createService = $this->confirm(
            "The directory '{$servicePath}' does not exist. Do you want to create it?",
            'yes'
        );

        if (!$createService) {
            $this->info('Controller creation canceled.');
            return;
        }

        // Create the service directory
        File::makeDirectory($servicePath, 0755, true);
    }
}

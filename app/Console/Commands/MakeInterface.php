<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInterface extends Command
{
    protected $signature = 'commander:make-interface {interface?} {--service=}';

    protected $description = 'Make service interface';

    public function handle()
    {
        $serviceName = $this->option('service');
        $interfaceName = $this->argument('interface');

        if (!$serviceName) {
            $serviceName = $this->askForServiceName();
        }

        if (!$interfaceName) {
            $interfaceName = $this->askForInterfaceName($serviceName);
        }

        $servicesRootDir = config('commander.service_path');
        $stubFilePath = config('commander.stub_files_path') . '/ExampleInterface.stub';

        if (!File::isFile($stubFilePath)) {
            $this->error("The stub file '{$stubFilePath}' does not exist.");
            return 0;
        }


        $servicePath = $servicesRootDir . '/' . $serviceName;
        $interfacePath = $servicePath . "/Interfaces";
        $interfaceFilePath = "${interfacePath}/${interfaceName}.ts";

        if (!File::isDirectory($servicePath)) {
            $this->askForServiceCreationIfNotExists($servicePath);
        }

        if (!File::isDirectory($interfaceFilePath)) {
            File::makeDirectory($interfaceFilePath, 0755, true);
        }


        if (File::exists($interfaceFilePath)) {
            $this->error("The file '{$interfaceFilePath}' already exists. Please choose a different name.");
        } else {
            // Copy the stub file to the service directory
            File::copy($stubFilePath, $interfaceFilePath);

            $this->replaceInterfacePlaceholders(
                $interfaceFilePath,
                $interfaceName
            );

            $this->info('Your interface has been created.');
            $this->line($interfaceFilePath);
            $this->newLine(1);

        }
        return 0;
    }

    private function replaceInterfacePlaceholders(
        string $filePath,
        string $interfaceName
    ): void {
        $content = File::get($filePath);

        // Replace placeholders with actual class names
        $content = str_replace('ExampleInterface', $interfaceName, $content);

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

    private function askForInterfaceName($serviceName)
    {
        return $this->anticipate(
            'Enter the interface name',
            $this->getInterfaceNameSuggestions($serviceName)
        );
    }

    private function getInterfaceNameSuggestions($serviceName): array
    {
        return collect([$serviceName])
            ->map(function ($name) {
                return "${name}Interface";
            })->toArray();
    }

    private function askForServiceCreationIfNotExists($servicePath): void
    {
        $createService = $this->confirm(
            "The directory '{$servicePath}' does not exist. Do you want to create it?",
            'yes'
        );

        if (!$createService) {
            $this->info('Interface creation canceled.');
            return;
        }

        // Create the service directory
        File::makeDirectory($servicePath, 0755, true);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commander:make-action {action?} {--service=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $serviceName = $this->option('service');
        $actionName = $this->argument('action');

        if (!$serviceName) {
            $serviceName = $this->askForServiceName();
        }

        if (!$actionName) {
            $actionName = $this->askForActionName($serviceName);
        }


        $servicesRootDir = config('commander.service_path');
        $stubFilePath = config('commander.stub_files_path') . '/ExampleAction.stub';

        if(!File::isFile($stubFilePath)){
            $this->error("The stub file '{$stubFilePath}' does not exist.");
            return 0;
        }

        $servicePath = $servicesRootDir . '/' . $serviceName;
        $actionPath = $servicePath . "/Actions";
        $actionFileFilePath = "${actionPath}/${actionName}.ts";

        if (!File::isDirectory($servicePath)) {
            $this->askForServiceCreationIfNotExists($servicePath);
        }

        if (!File::isDirectory($actionPath)) {
            File::makeDirectory($actionPath, 0755, true);
        }

        if(File::exists($actionFileFilePath)){
            $this->error("The file '{$actionFileFilePath}' already exists. Please choose a different name.");
        }else{
            // Copy the stub file to the service directory
            File::copy($stubFilePath, $actionFileFilePath);

            $this->replaceActionPlaceholders(
                $actionFileFilePath,
                $actionName
            );

            $this->info('You action has been created.');
            $this->line($actionFileFilePath);
            $this->newLine(1);

            return 0;
        }

    }

    private function askForServiceCreationIfNotExists($servicePath): void
    {
        $createService = $this->confirm(
            "The directory '{$servicePath}' does not exist. Do you want to create it?",
            'yes'
        );

        if (!$createService) {
            $this->info('Action creation canceled.');
            return;
        }

        // Create the service directory
        File::makeDirectory($servicePath, 0755, true);
    }

    private function askForServiceName()
    {
        return $this->anticipate(
            'What is the service name?',
            $this->getServiceNameSuggestions()
        );
    }

    private function askForActionName($serviceName)
    {
        return $this->anticipate(
            'Enter the action name',
            $this->getActionNameSuggestions($serviceName)
        );
    }

    private function getServiceNameSuggestions(): array
    {
        return collect(File::directories(config('commander.service_path')))
            ->map(function ($directory) {
                return pathinfo($directory, PATHINFO_BASENAME);
            })->toArray();
    }

    private function getActionNameSuggestions($serviceName): array
    {
        return collect([$serviceName])
            ->map(function ($name) {
                return "${name}Action";
            })->toArray();
    }

    private function replaceActionPlaceholders(
        string $filePath,
        string $actionName
    ): void
    {
        $content = File::get($filePath);

        // Replace placeholders with actual class names
        $content = str_replace('ExampleAction', $actionName, $content);

        // Save the modified content back to the file
        File::put($filePath, $content);
    }
}

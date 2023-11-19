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
    protected $signature = 'commander:make-repository';

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
        $servicesRootDir = config('commander.service_path');
        $stubFilePath = config('commander.stub_files_path') . '/ExampleRepository.stub';

        if(!File::isFile($stubFilePath)){
            $this->error("The stub file '{$stubFilePath}' does not exist.");
            return 0;
        }


        $serviceNames = collect(File::directories($servicesRootDir))
            ->map(function($directory){
                return pathinfo($directory, PATHINFO_BASENAME);
            })->toArray();

        $serviceName = $this->anticipate('What is the service name?', $serviceNames);

        $servicePath = $servicesRootDir . '/' . $serviceName;

        if (!File::isDirectory($servicePath)) {
            $this->error("The directory '{$servicePath}' does not exist.");
            return 0;
        }


        $repositoryNameSuggestions = collect($serviceNames)
            ->map(function($name){
               return "${name}Repository";
            })->toArray();

        $repositoryName = $this->anticipate('Enter the repository name', $repositoryNameSuggestions);
        $repositoryDestinationPath = $servicePath . '/Repositories/' . $repositoryName . ".ts";

        if(File::isFile($repositoryDestinationPath)){
            dd('Want to rename?');
        }else{
            // Copy the stub file to the service directory
            File::copy($stubFilePath, $repositoryDestinationPath);

            $this->replaceRepositoryPlaceholders(
                $repositoryDestinationPath,
                $repositoryName
            );

            $this->info('You repository has been created.');
            $this->line($repositoryDestinationPath);
            $this->newLine(1);

            return 0;
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
}

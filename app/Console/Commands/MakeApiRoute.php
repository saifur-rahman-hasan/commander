<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

class MakeApiRoute extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commander:make-api-route {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a next js api route with next 13 app directory support';


    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'What is the name of your route?',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routeName = $this->argument('name');
        $templateName = $this->ask('template', 'example_crud_api');
        $apiOutputPath = config('commander.api_output_path'). "/$routeName";
        $apiInputPath = config('commander.api_input_path') . '/' . $templateName;

        // Create the service directory if it doesn't exist
        $this->createDirectory($apiOutputPath);

        // TODO: Copy everything from the $crudApiStubFilePath directory to $apiRoutePath
        $this->copyAndChangeExtension($apiInputPath, $apiOutputPath);
    }

    private function createDirectory(string $directoryPath): void
    {
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
    }

    /**
     * Copy everything from the source directory to the destination directory and change file extensions.
     *
     * @param string $source
     * @param string $destination
     */
    private function copyAndChangeExtension(string $source, string $destination): void
    {
        // Get all files in the source directory
        $files = File::allFiles($source);

        foreach ($files as $file) {
            // Get the relative path of the file
            $relativePath = $file->getRelativePathname();

            // Create the destination path
            $destinationPath = $destination . '/' . $relativePath;

            // Create the destination directory if it doesn't exist
            $this->createDirectory(dirname($destinationPath));

            // Copy the file to the destination directory
            File::copy($file->getRealPath(), $destinationPath);

            // Change the file extension to .ts
            $newDestinationPath = pathinfo($destinationPath, PATHINFO_DIRNAME) . '/' . pathinfo($destinationPath, PATHINFO_FILENAME) . '.ts';
            File::move($destinationPath, $newDestinationPath);

            $this->info("Copied and renamed: $relativePath to " . pathinfo($destinationPath, PATHINFO_FILENAME) . '.ts');
        }
    }
}

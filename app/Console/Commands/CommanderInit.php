<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CommanderInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commander:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the Commander';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing Commander...');

        // Check if the core directory exists
        $coreDirectory = config('commander.commander_output_path') . '/core';

        if (!File::exists($coreDirectory)) {
            // If not, create it
            File::makeDirectory($coreDirectory);
            $this->info('Core directory created successfully.');
        } else {
            $this->comment('Core directory already exists.');
        }


        // Copy and rename stub files from app/Console/Commands/stubs/core directory
        $stubDirectory = config('commander.core_path');
        $outputPath = config('commander.commander_output_path') . '/core';

        if (File::isDirectory($stubDirectory)) {
            // Get all files in the stub directory
            $files = File::allFiles($stubDirectory);

            foreach ($files as $file) {
                // Get the file name without extension
                $fileNameWithoutExtension = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Create the new file name with .ts extension
                $newFileName = $fileNameWithoutExtension . '.ts';

                // Copy the file to the core directory with the new name
                $outputFilePath = $outputPath . "/" . $newFileName;

                File::copy($file->getRealPath(), $outputFilePath);
                $this->info("Copied and renamed: $outputFilePath");
            }
        } else {
            $this->error('Stub directory not found: ' . $stubDirectory);
        }

        $this->info('Commander initialization complete.');
    }
}

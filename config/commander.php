<?php

$commanderInputPath = "CommanderInput";
$commanderOutputPath = "CommanderOutput";
$commanderInputStbFilesPath = "CommanderInput/stubFiles";

return [
    'stub_files_path' => base_path($commanderInputStbFilesPath),
    'commander_input_path' => base_path($commanderInputPath),
    'commander_output_path' => base_path($commanderOutputPath),
    'core_path' => base_path("$commanderInputStbFilesPath/core"),
    'service_path' => base_path("$commanderOutputPath/services"),
    'app_path' => base_path("$commanderOutputPath/app"),
    'api_path' => base_path("$commanderInputStbFilesPath/app/api"),
    'api_input_path' => base_path("$commanderInputStbFilesPath/app/api"),
    'api_output_path' => base_path("$commanderOutputPath/app/api")
];

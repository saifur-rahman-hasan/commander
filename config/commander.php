<?php

$commanderOutputPath = "ConverseCommanderOutput";

return [
    'stub_files_path' => app_path('Console/Commands/ConverseStubs'),
    'commander_output_path' => base_path($commanderOutputPath),
    'core_path' => base_path("$commanderOutputPath/core"),
    'service_path' => base_path("$commanderOutputPath/services"),
    'app_path' => base_path("$commanderOutputPath/app"),
    'api_path' => base_path("$commanderOutputPath/app/api")
];

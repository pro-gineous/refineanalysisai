<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration for the OpenAI API client.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-4o'),
    'max_tokens' => env('OPENAI_MAX_TOKENS', 2048),
    'temperature' => env('OPENAI_TEMPERATURE', 0.7),
];

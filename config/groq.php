<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Groq API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Groq API (https://groq.com/)
    | Groq provides ultra-fast LLM inference
    |
    */

    'api_key' => env('GROQ_API_KEY'),

    'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),

    'base_url' => 'https://api.groq.com/openai/v1',

    'timeout' => env('GROQ_TIMEOUT', 60),

    'temperature' => env('GROQ_TEMPERATURE', 0.3),

    'max_tokens' => env('GROQ_MAX_TOKENS', 8000),

    /*
    |--------------------------------------------------------------------------
    | Available Models
    |--------------------------------------------------------------------------
    |
    | Groq supports multiple models:
    | - llama-3.1-70b-versatile: Best for complex analysis (RECOMMENDED)
    | - llama-3.1-8b-instant: Fast responses, good quality
    | - mixtral-8x7b-32768: Large context window
    | - gemma-7b-it: Google's Gemma model
    |
    */

    'models' => [
        'llama-3.3-70b-versatile',
        'llama-3.1-8b-instant',
        'mixtral-8x7b-32768',
        'gemma-7b-it',
    ],

];

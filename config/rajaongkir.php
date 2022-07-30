<?php

return [
    /*
     * Get your API Key from rajaongkir.com by registering your account
     */
    'api_key' => env('RAJAONGKIR_API_KEY', 'e55aa5e5dccabb59c6701ff3b5c9b90d'),

    /*
     * Set your account package type
     * Example: basic, starter, pro
     */
    'package' => env('RAJAONGKIR_PACKAGE', 'starter'),

    /*
     * Table name settings for caching provinces, cities, and districts
     */
    'table_prefix' => 'rajaongkir_',

    /*
     * Set the connection timeout for the requests
     */
    'timeout' => env('RAJAONGKIR_TIMEOUT', 30),
];
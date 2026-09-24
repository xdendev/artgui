<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Configuration
    |--------------------------------------------------------------------------
    */

    'title' => 'Artisan',

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | Disabled by default: routes are registered only when the flag is set
    | explicitly, so the GUI never shows up in an environment by accident.
    |
    */
    'enabled' => (bool) env('ARTGUI_PACKAGE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Basic credentials
    |--------------------------------------------------------------------------
    |
    | Always applied to the GUI routes. If either value is empty, every request
    | is rejected with 403 — the GUI cannot be opened without credentials.
    |
    */
    'auth' => [
        'username' => env('ARTGUI_USERNAME'),
        'password' => env('ARTGUI_PASSWORD'),
    ],

    'prefix' => 'artgui',

    /*
    |--------------------------------------------------------------------------
    | Middleware list for web routes
    |--------------------------------------------------------------------------
    |
    | Extra middleware for the GUI routes, by default it's just [web] group.
    | HTTP Basic auth (see [auth]) is always applied before these and cannot
    | be removed here.
    |
    */
    'middlewares' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Home url
    |--------------------------------------------------------------------------
    |
    | Where to go when [home] button is pressed
    |
    */
    'home' => '/',

    /*
    |--------------------------------------------------------------------------
    | List of commands
    |--------------------------------------------------------------------------
    |
    | Whitelist of commands available in the GUI, grouped by key. Empty by
    | default: publish the config and list only what is safe to run from a
    | browser. Commands that never finish (serve, queue:work) and interactive
    | ones are not supported — execution is synchronous and non-interactive.
    |
    | Example:
    |   'commands' => [
    |       'cache' => ['cache:clear', 'config:clear'],
    |       'info' => ['route:list', 'migrate:status'],
    |   ],
    |
    */
    'commands' => [],
];

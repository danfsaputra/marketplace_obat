<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Panel Providers
    |--------------------------------------------------------------------------
    |
    | Daftarkan panel Filament di sini. Panel utama biasanya admin.
    |
    */
    'panel-providers' => [
        \App\Providers\Filament\AdminPanelProvider::class,
        // Tambahkan panel lain jika ada
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | Path default untuk Filament jika tidak menggunakan panel.
    |
    */
    'path' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Filament Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware yang digunakan oleh Filament.
    |
    */
    'middleware' => [
        'web',
        // Tambahkan middleware lain jika perlu
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Auth Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware untuk autentikasi Filament.
    |
    */
    'auth_middleware' => [
        \Filament\Http\Middleware\Authenticate::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Branding
    |--------------------------------------------------------------------------
    |
    | Branding untuk panel Filament.
    |
    */
    'brand' => [
        'name' => env('APP_NAME', 'Marketplace Admin'),
        'logo' => null, // Path ke logo jika ada
        'favicon' => null, // Path ke favicon jika ada
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Theme
    |--------------------------------------------------------------------------
    |
    | Pengaturan tema warna Filament.
    |
    */
    'colors' => [
        'primary' => \Filament\Support\Colors\Color::Amber,
        // Tambahkan warna lain jika perlu
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Resources, Pages, Widgets
    |--------------------------------------------------------------------------
    |
    | Path untuk resource, page, dan widget.
    |
    */
    'resources_path' => app_path('Filament/Resources'),
    'pages_path' => app_path('Filament/Pages'),
    'widgets_path' => app_path('Filament/Widgets'),
];
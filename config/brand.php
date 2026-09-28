<?php

/*
|--------------------------------------------------------------------------
| Brand / White-Label Configuration
|--------------------------------------------------------------------------
|
| Every brand-specific value (name, colors, feature switches) is read from
| here. Business logic must gate brand behavior behind these keys instead
| of checking hostnames or environments inline.
|
*/

return [

    'id' => env('BRAND_ID', 'snapshare'),

    'name' => env('BRAND_NAME', 'SnapShare'),

    'tagline' => env('BRAND_TAGLINE', 'Share the moments that matter.'),

    'colors' => [
        'primary' => env('BRAND_COLOR_PRIMARY', '#4f46e5'),
        'primary_contrast' => env('BRAND_COLOR_PRIMARY_CONTRAST', '#ffffff'),
        'accent' => env('BRAND_COLOR_ACCENT', '#db2777'),
    ],

    'features' => [
        // Public sign-up. When disabled, /register responds 404.
        'registration' => (bool) env('BRAND_FEATURE_REGISTRATION', true),

        // Commenting on posts. When disabled, the comment policy denies creation.
        'comments' => (bool) env('BRAND_FEATURE_COMMENTS', true),
    ],

];

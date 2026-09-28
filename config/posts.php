<?php

/*
|--------------------------------------------------------------------------
| Post & Comment Content Rules
|--------------------------------------------------------------------------
|
| Application-level limits for photo posts and comments. These are shared
| with the frontend through Inertia so client-side checks mirror the
| server-side validation rules exactly.
|
*/

return [

    // Filesystem disk that stores original photos and generated thumbnails.
    'disk' => env('POSTS_DISK', 'public'),

    'photo' => [
        'max_kb' => (int) env('POSTS_PHOTO_MAX_KB', 5120),
        'mimes' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        // Guards the thumbnail job against decompression-bomb sized images.
        'max_dimension' => 8000,
    ],

    'thumbnail' => [
        'width' => 640,
        'quality' => 80,
    ],

    'caption_max_length' => 2200,

    'comment_max_length' => 1000,

    'page_size' => [
        'feed' => 10,
        'profile' => 12,
        'comments' => 20,
    ],

];

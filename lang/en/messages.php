<?php

return [

    'success' => 'OK',

    'auth' => [
        'registered' => 'Welcome to :brand, :name!',
        'logged_in' => 'Welcome back, :name!',
        'logged_out' => 'You have been signed out.',
        'failed' => 'These credentials do not match our records.',
        'throttled' => 'Too many sign-in attempts. Please try again in :seconds seconds.',
    ],

    'posts' => [
        'fetched' => 'Posts retrieved.',
        'retrieved' => 'Post retrieved.',
        'created' => 'Your photo has been posted.',
        'deleted' => 'Post deleted.',
        'create_failed' => 'We could not save your photo. Please try again.',
        'delete_failed' => 'We could not delete this post. Please try again.',
        'delete_forbidden' => 'You can only delete your own posts.',
    ],

    'comments' => [
        'fetched' => 'Comments retrieved.',
        'created' => 'Comment added.',
        'deleted' => 'Comment deleted.',
        'create_failed' => 'We could not save your comment. Please try again.',
        'disabled' => 'Comments are turned off.',
        'delete_forbidden' => 'You can only delete your own comments or comments on your posts.',
    ],

    'errors' => [
        'generic' => 'Something went wrong.',
        'unauthenticated' => 'Please sign in to continue.',
        'forbidden' => 'You are not allowed to do that.',
        'not_found' => 'The requested resource was not found.',
        'validation' => 'The given data was invalid.',
        'throttled' => 'Too many requests. Please slow down and try again shortly.',
        'session_expired' => 'Your session has expired. Please refresh the page and try again.',
        'server' => 'Something went wrong on our end. Please try again.',
        'feature_disabled' => 'This feature is not available.',
    ],

    'validation' => [
        'username_format' => 'The username may only contain lowercase letters, numbers, dots and underscores.',
    ],

    'attributes' => [
        'name' => 'name',
        'username' => 'username',
        'email' => 'email address',
        'password' => 'password',
        'photo' => 'photo',
        'caption' => 'caption',
        'body' => 'comment',
    ],

];

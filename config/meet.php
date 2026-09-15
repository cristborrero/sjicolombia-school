<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meet Driver
    |--------------------------------------------------------------------------
    |
    | 'manual' — Admin/teacher pastes links manually (default, always works)
    | 'google_calendar' — Auto-generate Meet links via Google Calendar API
    |
    */

    'driver' => env('MEET_DRIVER', 'manual'),

    /*
    |--------------------------------------------------------------------------
    | Google Calendar API Configuration
    |--------------------------------------------------------------------------
    |
    | Required only when MEET_DRIVER=google_calendar.
    | Requires a Google Workspace account with Calendar API enabled.
    |
    */

    'google_calendar' => [
        'credentials_path' => env('GOOGLE_CREDENTIALS_PATH', ''),
        'calendar_id' => env('GOOGLE_CALENDAR_ID', 'primary'),
    ],

];

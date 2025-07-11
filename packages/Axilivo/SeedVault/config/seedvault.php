<?php

return [
    'storage_path' => storage_path('app/seedvault'),
    'log_file' => storage_path('app/seedvault/snapshots.json'),
    'auto_backup' => true,
    'frequency' => 'daily',
    'keep_snapshots' => 5,
    'notification_api_url' => env('SEEDVAULT_NOTIFICATION_API_URL'),
];

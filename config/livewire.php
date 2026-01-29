<?php

return [
    'temporary_file_upload' => [
        // Keep Livewire temp uploads on local disk to avoid signed S3 temp upload flow.
        'disk' => 'local',
    ],
];

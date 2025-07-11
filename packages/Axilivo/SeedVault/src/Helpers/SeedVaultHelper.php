<?php

namespace Axilivo\SeedVault\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class SeedVaultHelper
{
    public static function getSeederClassName($filename)
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    public static function updateLog($entry)
    {
        $logPath = config('seedvault.log_file');

        if (!File::exists(dirname($logPath))) {
            File::makeDirectory(dirname($logPath), 0755, true);
        }

        $logs = File::exists($logPath) ? json_decode(File::get($logPath), true) ?? [] : [];

        $logs[] = $entry;

        File::put($logPath, json_encode($logs, JSON_PRETTY_PRINT));
    }

    public static function sendNotification($message)
    {
        $url = config('seedvault.notification_url');

        if ($url) {
            try {
                Http::post($url, ['message' => $message]);
            } catch (\Exception $e) {
                // Local test pe ignore
            }
        }
    }
}

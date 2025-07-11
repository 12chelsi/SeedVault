<?php

namespace Axilivo\SeedVault\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Axilivo\SeedVault\Helpers\SeedVaultHelper;

class SnapshotController extends Controller
{
    protected $snapshotPath;

    public function __construct()
    {
        $this->snapshotPath = config('seedvault.storage_path');
    }

    public function index()
    {
        $files = File::exists($this->snapshotPath) ? File::files($this->snapshotPath) : [];
        return view('seedvault::index', compact('files'));
    }

   public function create()
{
    // Call artisan command
    Artisan::call('seedvault:snapshot');

    // Last created file name fetch karna (Helper ya direct logic se)
    $timestamp = now()->format('Ymd_His');
    $fileName = "Snapshot_{$timestamp}_StudentSeeder.php";

    // Fetch database content for confirmation/debugging
    $students = \App\Models\Student::all()->toArray();

    return back()->with([
        'success' => 'Snapshot created!',
        'file_name' => $fileName,
        'time' => now()->toDateTimeString(),
        'students' => $students
    ]);
}


    public function restore(Request $request)
    {
        $snapshots = $request->input('snapshots');

        if (!$snapshots) {
            return back()->with('error', 'Select at least one snapshot.');
        }

        foreach ($snapshots as $file) {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed', [
                '--class' => "SeedVault\\" . SeedVaultHelper::getSeederClassName($file)
            ]);

            SeedVaultHelper::updateLog([
                'file' => $file,
                'action' => 'restore',
                'time' => now(),
            ]);

            SeedVaultHelper::sendNotification("Snapshot restored: $file");
        }

        return back()->with('success', 'Restore completed!');
    }

    public function delete(Request $request)
    {
        $snapshots = $request->input('snapshots');

        if (!$snapshots) {
            return back()->with('error', 'Select at least one snapshot.');
        }

        foreach ($snapshots as $file) {
            $fullPath = $this->snapshotPath . '/' . $file;
            if (File::exists($fullPath)) {
                File::delete($fullPath);

                SeedVaultHelper::updateLog([
                    'file' => $file,
                    'action' => 'delete',
                    'time' => now(),
                ]);

                SeedVaultHelper::sendNotification("Snapshot deleted: $file");
            }
        }

        return back()->with('success', 'Snapshots deleted!');
    }
}

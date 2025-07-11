<?php

namespace Axilivo\SeedVault\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Axilivo\SeedVault\Helpers\SeedVaultHelper;

class CreateSnapshotCommand extends Command
{
    protected $signature = 'seedvault:snapshot';
    protected $description = 'Create a database snapshot as Seeder file.';

    public function handle()
    {
        $path = base_path("database/seeders/SeedVault");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $timestamp = now()->format('Ymd_His');
        $seederName = "Snapshot_{$timestamp}_StudentSeeder";
        $seederFilePath = "{$path}/{$seederName}.php";

        $students = DB::table('students')->get()->toArray();
        $studentsArray = json_decode(json_encode($students), true);
        $studentsData = var_export($studentsArray, true);

        $seederContent = "<?php

namespace Database\\Seeders\\SeedVault;

use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;

class {$seederName} extends Seeder
{
    public function run()
    {
        DB::table('students')->truncate();
        DB::table('students')->insert({$studentsData});
    }
}
";

        file_put_contents($seederFilePath, $seederContent);

        SeedVaultHelper::updateLog([
            'file' => "{$seederName}.php",
            'action' => 'create',
            'time' => now(),
        ]);

        SeedVaultHelper::sendNotification("Snapshot created via CLI: {$seederName}");

        $this->info("Snapshot created with data: {$seederName}.php");
    }
}

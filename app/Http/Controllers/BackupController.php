<?php

namespace App\Http\Controllers;

use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    public function backupAndDownload()
    {
        // Ejecuta la tarea de respaldo
        $backup = BackupJobFactory::createFromArray(config('backup'));

        $backup->run();

        // Descarga el último respaldo
        $backupDestination = $backup->getBackupDestinations()[0];
        $latestBackup = $backupDestination->getBackups()->first();

        return $this->downloadBackup($latestBackup);
    }

    protected function downloadBackup(Backup $backup): BinaryFileResponse
    {
        $backupPath = $backup->path();

        return response()->download($backupPath, $backup->filename(), [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=' . $backup->filename(),
        ]);
    }
}

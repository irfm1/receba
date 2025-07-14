<?php

namespace App\Livewire;

use App\Services\BackupService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Gestão de Backups')]
class BackupManager extends Component
{
    use WithFileUploads;
    
    public $backups = [];
    public $isCreatingBackup = false;
    public $uploadedBackup;
    public $showRestoreModal = false;
    public $backupToRestore;
    
    protected $backupService;
    
    public function mount()
    {
        $this->backupService = new BackupService();
        $this->loadBackups();
    }
    
    public function loadBackups()
    {
        $this->backups = $this->backupService->getBackupList();
    }
    
    public function createBackup()
    {
        $this->isCreatingBackup = true;
        
        try {
            $result = $this->backupService->createFullBackup();
            
            if ($result['success']) {
                $this->dispatch('backup-created', [
                    'message' => 'Backup criado com sucesso!',
                    'backup' => $result
                ]);
                
                $this->loadBackups();
            } else {
                $this->dispatch('backup-error', [
                    'message' => 'Erro ao criar backup: ' . $result['error']
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('backup-error', [
                'message' => 'Erro inesperado: ' . $e->getMessage()
            ]);
        } finally {
            $this->isCreatingBackup = false;
        }
    }
    
    public function downloadBackup($backupName)
    {
        try {
            return $this->backupService->downloadBackup($backupName);
        } catch (\Exception $e) {
            $this->dispatch('backup-error', [
                'message' => 'Erro ao baixar backup: ' . $e->getMessage()
            ]);
        }
    }
    
    public function deleteBackup($backupName)
    {
        try {
            $success = $this->backupService->deleteBackup($backupName);
            
            if ($success) {
                $this->dispatch('backup-deleted', [
                    'message' => 'Backup deletado com sucesso!'
                ]);
                
                $this->loadBackups();
            } else {
                $this->dispatch('backup-error', [
                    'message' => 'Erro ao deletar backup'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('backup-error', [
                'message' => 'Erro inesperado: ' . $e->getMessage()
            ]);
        }
    }
    
    public function confirmRestore($backupName)
    {
        $this->backupToRestore = $backupName;
        $this->showRestoreModal = true;
    }
    
    public function cancelRestore()
    {
        $this->showRestoreModal = false;
        $this->backupToRestore = null;
    }
    
    public function restoreBackup()
    {
        if (!$this->backupToRestore) {
            return;
        }
        
        try {
            $result = $this->backupService->restoreBackup($this->backupToRestore);
            
            if ($result['success']) {
                $this->dispatch('backup-restored', [
                    'message' => 'Backup restaurado com sucesso!'
                ]);
                
                $this->loadBackups();
            } else {
                $this->dispatch('backup-error', [
                    'message' => 'Erro ao restaurar backup: ' . $result['error']
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('backup-error', [
                'message' => 'Erro inesperado: ' . $e->getMessage()
            ]);
        } finally {
            $this->showRestoreModal = false;
            $this->backupToRestore = null;
        }
    }
    
    public function getSystemInfoProperty()
    {
        return [
            'database_size' => $this->getDatabaseSize(),
            'files_size' => $this->getFilesSize(),
            'total_backups' => count($this->backups),
            'last_backup' => $this->backups[0] ?? null,
            'disk_usage' => $this->getDiskUsage(),
        ];
    }
    
    private function getDatabaseSize()
    {
        $dbPath = database_path('database.sqlite');
        return file_exists($dbPath) ? filesize($dbPath) : 0;
    }
    
    private function getFilesSize()
    {
        $publicPath = storage_path('app/public');
        $imagesPath = public_path('images');
        
        $totalSize = 0;
        
        if (is_dir($publicPath)) {
            $totalSize += $this->getDirectorySize($publicPath);
        }
        
        if (is_dir($imagesPath)) {
            $totalSize += $this->getDirectorySize($imagesPath);
        }
        
        return $totalSize;
    }
    
    private function getDirectorySize($directory)
    {
        $size = 0;
        
        if (is_dir($directory)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            
            foreach ($iterator as $file) {
                $size += $file->getSize();
            }
        }
        
        return $size;
    }
    
    private function getDiskUsage()
    {
        $backupPath = storage_path('app/backups');
        return is_dir($backupPath) ? $this->getDirectorySize($backupPath) : 0;
    }
    
    public function render()
    {
        return view('livewire.backup-manager', [
            'systemInfo' => $this->systemInfo,
        ]);
    }
}

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
    public $showDeleteModal = false;
    public $backupToRestore;
    public $selectedBackup;
    public $backupFile;
    public $autoBackupEnabled = false;
    
    protected $backupService;
    
    public function mount()
    {
        $this->backupService = new BackupService();
        $this->loadBackups();
    }
    
    public function loadBackups()
    {
        if (!$this->backupService) {
            $this->backupService = new BackupService();
        }
        $this->backups = $this->backupService->getBackupList();
    }
    
    public function createBackup()
    {
        $this->isCreatingBackup = true;
        
        try {
            if (!$this->backupService) {
                $this->backupService = new BackupService();
            }
            
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
    
    public function refreshStorageInfo()
    {
        // This will trigger a re-render with fresh data
        $this->loadBackups();
    }
    
    public function refreshBackupList()
    {
        $this->loadBackups();
    }
    
    public function downloadBackup($filename)
    {
        try {
            if (!$this->backupService) {
                $this->backupService = new BackupService();
            }
            return $this->backupService->downloadBackup($filename);
        } catch (\Exception $e) {
            $this->dispatch('backup-error', [
                'message' => 'Erro ao baixar backup: ' . $e->getMessage()
            ]);
        }
    }
    
    public function confirmRestore($filename)
    {
        $this->selectedBackup = $filename;
        $this->showRestoreModal = true;
    }
    
    public function cancelRestore()
    {
        $this->showRestoreModal = false;
        $this->selectedBackup = null;
    }
    
    public function restoreBackup()
    {
        if (!$this->selectedBackup) {
            return;
        }
        
        try {
            if (!$this->backupService) {
                $this->backupService = new BackupService();
            }
            
            $result = $this->backupService->restoreBackup($this->selectedBackup);
            
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
            $this->selectedBackup = null;
        }
    }
    
    public function confirmDelete($filename)
    {
        $this->selectedBackup = $filename;
        $this->showDeleteModal = true;
    }
    
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->selectedBackup = null;
    }
    
    public function deleteBackup()
    {
        if (!$this->selectedBackup) {
            return;
        }
        
        try {
            if (!$this->backupService) {
                $this->backupService = new BackupService();
            }
            
            $success = $this->backupService->deleteBackup($this->selectedBackup);
            
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
        } finally {
            $this->showDeleteModal = false;
            $this->selectedBackup = null;
        }
    }
    
    public function restoreFromFile()
    {
        if (!$this->backupFile) {
            return;
        }
        
        try {
            if (!$this->backupService) {
                $this->backupService = new BackupService();
            }
            
            // Handle file upload and restore logic
            $result = $this->backupService->restoreFromFile($this->backupFile);
            
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
        }
    }

    public function getSystemInfoProperty()
    {
        return [
            'database_size' => $this->formatBytes($this->getDatabaseSize()),
            'files_size' => $this->formatBytes($this->getFilesSize()),
            'total_backups' => count($this->backups),
            'last_backup' => $this->backups[0] ?? null,
            'disk_usage' => $this->formatBytes($this->getDiskUsage()),
        ];
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
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

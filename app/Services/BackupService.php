<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use ZipArchive;

class BackupService
{
    private $backupPath = 'backups';
    
    public function createFullBackup(): array
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = "backup_completo_{$timestamp}";
            
            // Criar diretório de backup
            Storage::disk('local')->makeDirectory($this->backupPath);
            
            // Backup do banco de dados
            $dbBackup = $this->createDatabaseBackup($backupName);
            
            // Backup dos arquivos
            $filesBackup = $this->createFilesBackup($backupName);
            
            // Criar arquivo ZIP
            $zipFile = $this->createZipBackup($backupName, $dbBackup, $filesBackup);
            
            // Limpar arquivos temporários
            $this->cleanTemporaryFiles($dbBackup, $filesBackup);
            
            return [
                'success' => true,
                'backup_name' => $backupName,
                'file_path' => $zipFile,
                'size' => Storage::disk('local')->size($zipFile),
                'created_at' => Carbon::now(),
            ];
            
        } catch (\Exception $e) {
            Log::error('Erro ao criar backup: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    
    private function createDatabaseBackup(string $backupName): string
    {
        $dbPath = database_path('database.sqlite');
        $backupDbPath = storage_path("app/{$this->backupPath}/{$backupName}_database.sqlite");
        
        // Copiar arquivo SQLite
        copy($dbPath, $backupDbPath);
        
        return $backupDbPath;
    }
    
    private function createFilesBackup(string $backupName): string
    {
        $filesPath = storage_path("app/{$this->backupPath}/{$backupName}_files");
        
        // Criar diretório para arquivos
        if (!file_exists($filesPath)) {
            mkdir($filesPath, 0755, true);
        }
        
        // Copiar arquivos importantes
        $this->copyDirectory(storage_path('app/public'), $filesPath . '/public');
        $this->copyDirectory(public_path('images'), $filesPath . '/images');
        
        return $filesPath;
    }
    
    private function createZipBackup(string $backupName, string $dbBackup, string $filesBackup): string
    {
        $zipPath = storage_path("app/{$this->backupPath}/{$backupName}.zip");
        
        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Não foi possível criar o arquivo ZIP');
        }
        
        // Adicionar banco de dados
        $zip->addFile($dbBackup, 'database.sqlite');
        
        // Adicionar arquivos
        $this->addDirectoryToZip($zip, $filesBackup, 'files');
        
        // Adicionar informações do sistema
        $systemInfo = $this->getSystemInfo();
        $zip->addFromString('system_info.json', json_encode($systemInfo, JSON_PRETTY_PRINT));
        
        $zip->close();
        
        return "{$this->backupPath}/{$backupName}.zip";
    }
    
    private function addDirectoryToZip(ZipArchive $zip, string $directory, string $localPath = '')
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            $filePath = $file->getRealPath();
            $relativePath = $localPath . '/' . substr($filePath, strlen($directory) + 1);
            
            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
    
    private function copyDirectory(string $source, string $destination)
    {
        if (!is_dir($source)) {
            return;
        }
        
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            $destinationPath = $destination . '/' . $iterator->getSubPathName();
            
            if ($file->isDir()) {
                mkdir($destinationPath, 0755, true);
            } else {
                copy($file, $destinationPath);
            }
        }
    }
    
    private function cleanTemporaryFiles(string $dbBackup, string $filesBackup)
    {
        // Remover backup temporário do banco
        if (file_exists($dbBackup)) {
            unlink($dbBackup);
        }
        
        // Remover diretório temporário de arquivos
        if (is_dir($filesBackup)) {
            $this->removeDirectory($filesBackup);
        }
    }
    
    private function removeDirectory(string $directory)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        
        rmdir($directory);
    }
    
    private function getSystemInfo(): array
    {
        return [
            'app_name' => config('app.name'),
            'app_version' => '1.0.0',
            'backup_date' => Carbon::now()->toISOString(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_type' => 'SQLite',
            'tables_count' => DB::select("SELECT COUNT(*) as count FROM sqlite_master WHERE type='table'")[0]->count,
            'total_records' => [
                'users' => DB::table('users')->count(),
                'customers' => DB::table('customers')->count(),
                'invoices' => DB::table('invoices')->count(),
                'technical_reports' => DB::table('technical_reports')->count(),
                'service_templates' => DB::table('service_templates')->count(),
                'service_packages' => DB::table('service_packages')->count(),
            ],
        ];
    }
    
    public function getBackupList(): array
    {
        $backups = [];
        $files = Storage::disk('local')->files($this->backupPath);
        
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $backups[] = [
                    'name' => basename($file, '.zip'),
                    'file' => $file,
                    'size' => Storage::disk('local')->size($file),
                    'created_at' => Carbon::createFromTimestamp(Storage::disk('local')->lastModified($file)),
                ];
            }
        }
        
        // Ordenar por data de criação (mais recente primeiro)
        usort($backups, function($a, $b) {
            return $b['created_at']->timestamp - $a['created_at']->timestamp;
        });
        
        return $backups;
    }
    
    public function deleteBackup(string $backupName): bool
    {
        try {
            $filePath = "{$this->backupPath}/{$backupName}.zip";
            
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Erro ao deletar backup: ' . $e->getMessage());
            return false;
        }
    }
    
    public function downloadBackup(string $backupName): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filePath = "{$this->backupPath}/{$backupName}.zip";
        
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'Backup não encontrado');
        }
        
        return Storage::disk('local')->download($filePath, "{$backupName}.zip");
    }
    
    public function restoreBackup(string $backupName): array
    {
        try {
            $filePath = storage_path("app/{$this->backupPath}/{$backupName}.zip");
            
            if (!file_exists($filePath)) {
                throw new \Exception('Arquivo de backup não encontrado');
            }
            
            // Criar backup atual antes de restaurar
            $currentBackup = $this->createFullBackup();
            
            $zip = new ZipArchive();
            
            if ($zip->open($filePath) !== TRUE) {
                throw new \Exception('Não foi possível abrir o arquivo de backup');
            }
            
            // Extrair para diretório temporário
            $tempDir = storage_path('app/temp_restore');
            $zip->extractTo($tempDir);
            $zip->close();
            
            // Restaurar banco de dados
            $this->restoreDatabase($tempDir . '/database.sqlite');
            
            // Restaurar arquivos
            $this->restoreFiles($tempDir . '/files');
            
            // Limpar diretório temporário
            $this->removeDirectory($tempDir);
            
            return [
                'success' => true,
                'message' => 'Backup restaurado com sucesso',
                'backup_created' => $currentBackup,
            ];
            
        } catch (\Exception $e) {
            Log::error('Erro ao restaurar backup: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    
    private function restoreDatabase(string $backupDbPath): void
    {
        if (!file_exists($backupDbPath)) {
            throw new \Exception('Arquivo de banco de dados não encontrado no backup');
        }
        
        $currentDbPath = database_path('database.sqlite');
        
        // Fazer backup do banco atual
        copy($currentDbPath, $currentDbPath . '.bak');
        
        // Restaurar banco do backup
        copy($backupDbPath, $currentDbPath);
    }
    
    private function restoreFiles(string $backupFilesPath): void
    {
        if (!is_dir($backupFilesPath)) {
            return;
        }
        
        // Restaurar arquivos públicos
        if (is_dir($backupFilesPath . '/public')) {
            $this->copyDirectory($backupFilesPath . '/public', storage_path('app/public'));
        }
        
        // Restaurar imagens
        if (is_dir($backupFilesPath . '/images')) {
            $this->copyDirectory($backupFilesPath . '/images', public_path('images'));
        }
    }
    
    public function scheduleAutomaticBackup(): void
    {
        // Esta função pode ser chamada por um comando Artisan agendado
        $backup = $this->createFullBackup();
        
        if ($backup['success']) {
            Log::info('Backup automático criado com sucesso: ' . $backup['backup_name']);
            
            // Limpar backups antigos (manter apenas os últimos 10)
            $this->cleanOldBackups(10);
        } else {
            Log::error('Falha ao criar backup automático: ' . $backup['error']);
        }
    }
    
    private function cleanOldBackups(int $keepCount): void
    {
        $backups = $this->getBackupList();
        
        if (count($backups) > $keepCount) {
            $backupsToDelete = array_slice($backups, $keepCount);
            
            foreach ($backupsToDelete as $backup) {
                $this->deleteBackup($backup['name']);
                Log::info('Backup antigo removido: ' . $backup['name']);
            }
        }
    }
    
    public function restoreFromFile($uploadedFile): array
    {
        try {
            // Save the uploaded file temporarily
            $tempPath = $uploadedFile->store('temp');
            
            // Restore from the temporary file
            $result = $this->restoreBackup(basename($tempPath));
            
            // Clean up temporary file
            Storage::disk('local')->delete($tempPath);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Erro ao restaurar backup do arquivo: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

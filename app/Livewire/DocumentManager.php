<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Document;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\TechnicalReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentManager extends Component
{
    use WithFileUploads, WithPagination;

    public $uploadedFiles = [];
    public $category = '';
    public $description = '';
    public $customer_id = '';
    public $invoice_id = '';
    public $technical_report_id = '';

    public $search = '';
    public $selectedCategory = '';
    public $selectedCustomer = '';

    public $showUploadModal = false;
    public $showDeleteModal = false;
    public $documentToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedCustomer' => ['except' => ''],
    ];

    protected $rules = [
        'uploadedFiles.*' => 'required|file|max:10240', // 10MB max
        'category' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'customer_id' => 'nullable|exists:customers,id',
        'invoice_id' => 'nullable|exists:invoices,id',
        'technical_report_id' => 'nullable|exists:technical_reports,id',
    ];

    public function render()
    {
        $documentsQuery = Document::with(['customer', 'invoice', 'technicalReport', 'uploadedBy']);

        if ($this->search) {
            $documentsQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $documentsQuery->where('category', $this->selectedCategory);
        }

        if ($this->selectedCustomer) {
            $documentsQuery->where('customer_id', $this->selectedCustomer);
        }

        $documents = $documentsQuery->orderBy('created_at', 'desc')->paginate(10);

        $categories = Document::distinct()->pluck('category')->filter();
        $customers = Customer::orderBy('name')->get();

        return view('livewire.document-manager', compact('documents', 'categories', 'customers'));
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset(['uploadedFiles', 'category', 'description', 'customer_id', 'invoice_id', 'technical_report_id']);
    }

    public function uploadDocuments()
    {
        $this->validate();

        foreach ($this->uploadedFiles as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $filename, 'public');

            Document::create([
                'name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'category' => $this->category,
                'description' => $this->description,
                'customer_id' => $this->customer_id ?: null,
                'invoice_id' => $this->invoice_id ?: null,
                'technical_report_id' => $this->technical_report_id ?: null,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Documentos enviados com sucesso!'
        ]);

        $this->closeUploadModal();
    }

    public function downloadDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->name);
        }

        $this->dispatch('notification', [
            'type' => 'error',
            'message' => 'Arquivo não encontrado!'
        ]);
    }

    public function confirmDelete($documentId)
    {
        $this->documentToDelete = $documentId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->documentToDelete = null;
    }

    public function deleteDocument()
    {
        $document = Document::findOrFail($this->documentToDelete);
        
        // Delete physical file
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        // Delete database record
        $document->delete();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Documento excluído com sucesso!'
        ]);

        $this->cancelDelete();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedCustomer']);
    }

    public function getStorageStats()
    {
        $totalSize = Document::sum('file_size');
        $totalCount = Document::count();
        
        return [
            'total_size' => $this->formatBytes($totalSize),
            'total_count' => $totalCount,
            'categories' => Document::select('category', \DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->get()
                ->pluck('count', 'category')
                ->toArray()
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

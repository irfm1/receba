<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('technical_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null');
            $table->string('service_order_number')->nullable(); // OS relacionada
            
            // Informações básicas do laudo
            $table->string('title');
            $table->text('description');
            $table->date('inspection_date');
            $table->date('report_date');
            $table->string('technician_name');
            $table->string('technician_registration')->nullable(); // Registro profissional
            
            // Tipo de laudo
            $table->enum('report_type', [
                'instalacao', 
                'manutencao', 
                'diagnostico', 
                'seguranca', 
                'performance', 
                'infraestrutura',
                'outros'
            ])->default('diagnostico');
            
            // Equipamentos/Sistemas analisados
            $table->json('equipment_analyzed')->nullable(); // Array de equipamentos
            
            // Resultados da análise
            $table->text('findings'); // Constatações
            $table->text('recommendations'); // Recomendações
            $table->text('observations')->nullable(); // Observações adicionais
            
            // Anexos e evidências
            $table->json('attachments')->nullable(); // Fotos, documentos, etc.
            
            // Status e aprovação
            $table->enum('status', ['draft', 'completed', 'approved', 'rejected'])->default('draft');
            $table->text('approval_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by')->nullable();
            
            // Validade do laudo
            $table->date('valid_until')->nullable();
            
            // Configurações
            $table->boolean('is_template')->default(false); // Para laudos modelo
            $table->string('template_name')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['customer_id', 'report_date']);
            $table->index('report_type');
            $table->index('status');
            $table->index('service_order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_reports');
    }
};

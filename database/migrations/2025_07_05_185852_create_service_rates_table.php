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
        Schema::create('service_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_template_id')->constrained()->onDelete('cascade');
            $table->string('customer_category');
            $table->string('complexity_level');
            $table->decimal('rate_per_hour', 10, 2);
            $table->decimal('minimum_hours', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['service_template_id', 'is_active']);
            $table->index(['customer_category', 'complexity_level']);
            $table->index(['valid_from', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_rates');
    }
};

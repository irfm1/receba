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
        Schema::create('service_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->decimal('base_rate_per_hour', 10, 2);
            $table->string('unit')->default('hour');
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('tags')->nullable();
            $table->json('requirements')->nullable();
            $table->json('deliverables')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['category', 'is_active']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_templates');
    }
};

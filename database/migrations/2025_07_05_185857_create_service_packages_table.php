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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->decimal('fixed_price', 10, 2);
            $table->integer('estimated_duration_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable();
            $table->json('requirements')->nullable();
            $table->json('deliverables')->nullable();
            $table->json('terms_conditions')->nullable();
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['category', 'is_active']);
            $table->index(['valid_from', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};

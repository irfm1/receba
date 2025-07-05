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
        Schema::create('package_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_template_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->decimal('custom_rate', 10, 2)->nullable();
            $table->timestamps();
            
            $table->unique(['service_package_id', 'service_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_services');
    }
};

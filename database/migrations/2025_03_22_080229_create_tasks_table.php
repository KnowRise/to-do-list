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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->enum('repeat_type', ['none', 'daily', 'weekly', 'monthly'])->default('none');
            $table->unsignedInteger('repeat_interval')->default(1);
            $table->unsignedInteger('repeat_count')->default(0);
            $table->unsignedInteger('repeat_gap')->default(1);
            $table->foreignUuid('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['start_date', 'end_date', 'repeat_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

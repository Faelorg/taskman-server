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
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id_role')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('close_project');
            $table->boolean('update_project');
            $table->boolean('create_column');
            $table->boolean('update_column');
            $table->boolean('delete_column');
            $table->boolean('create_task');
            $table->boolean('update_task');
            $table->boolean('delete_task');
            $table->uuid('id_project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

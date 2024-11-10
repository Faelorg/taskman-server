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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id_company')->primary();
            $table->string('name');
            $table->string('maincolor');
            $table->string('additionalcolor');
            $table->string('panelcolor');
            $table->string('outlinecolor');
            $table->string('truebuttoncolor');
            $table->string('cancelbuttoncolor');
            $table->string('selectedbuttoncolor');
            $table->string('fontcolor');
            $table->string('additionalfontcolor');
            $table->text('mainpage');
            $table->string('codetask');
            $table->string('smtpsender');
            $table->string('smtpserver')->nullable();
            $table->string('smtpport')->nullable();
            $table->string('smtppassword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

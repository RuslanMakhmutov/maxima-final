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
        Schema::connection('mongodb')->create('pollutions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('coord');
            $table->integer('dt');
            $table->string('main');
            $table->string('components');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('pollutions');
    }
};

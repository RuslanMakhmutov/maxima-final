<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function __construct()
    {
        if (app()->runningUnitTests()) {
            $this->connection = config('database.default');
        } else {
            $this->connection = 'mongodb';
        }
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pollutions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('coord');
            $table->integer('dt');
            $table->string('main');
            $table->string('components');
        });

        \Illuminate\Support\Facades\DB::connection($this->connection)->table('pollutions')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pollutions');
    }
};

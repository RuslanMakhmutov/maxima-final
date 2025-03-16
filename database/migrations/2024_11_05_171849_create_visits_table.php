<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('visits', function (Blueprint $table) {
            $table->comment('Просмотры');
            $table->id();
            $table->unsignedBigInteger('visitable_id')->index()->comment('Идентификатор просмотренного объекта');
            $table->string('visitable_type')->index()->comment('Тип просмотренного объекта');
            $table->unsignedBigInteger('user_id')->index()->nullable()->comment('Пользователь');
            $table->string('ip_address')->nullable();
            $table->string('browser')->nullable();
            $table->timestamps();
            $table->index(['visitable_id', 'visitable_type'], 'visitable_index');
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('visits');
    }
};

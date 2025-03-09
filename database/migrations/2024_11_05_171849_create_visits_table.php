<?php

use App\Models\User;
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
        Schema::create('visits', function (Blueprint $table) {
            $table->comment('Просмотры');
            $table->id();
            $table->unsignedBigInteger('visitable_id')->index()->comment('Идентификатор просмотренного объекта');
            $table->string('visitable_type')->index()->comment('Тип просмотренного объекта');
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index(['visitable_id', 'visitable_type'], 'visitable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

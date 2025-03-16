<?php

use App\Models\Category;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('Новости');
            $table->id();
            $table->string('title', 100)->comment('Заголовок новости');
            $table->string('description')->comment('Краткое описание');
            $table->text('content')->comment('Текст новости');
            $table->string('image')->nullable();
            $table->foreignIdFor(User::class)->index()->comment('Автор')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->index()->comment('Основная категория')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

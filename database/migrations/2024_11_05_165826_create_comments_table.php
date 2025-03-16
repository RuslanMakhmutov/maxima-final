<?php

use App\Models\Post;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->comment('Комментарии');
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->index()
                ->comment('Родительский комментарий')
                ->constrained('comments')
                ->onDelete('cascade');
            $table->foreignId('root_id')
                ->nullable()
                ->index()
                ->comment('Корневой комментарий в ветке')
                ->constrained('comments')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('level')->default(1)->comment('Уровень в ветке');
            $table->text('content')->comment('Текст комментария');
            $table->foreignIdFor(User::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Post::class)->index()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('comments');
    }
};

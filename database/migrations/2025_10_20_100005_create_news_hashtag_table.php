<?php

use App\Models\Pages\News;
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
        Schema::create('news_hashtag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(News::class)->constrained()->cascadeOnDelete();
            $table->foreignId('hashtag_id')->constrained('hashtags')->cascadeOnDelete();
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['news_id', 'hashtag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_hashtag');
    }
};

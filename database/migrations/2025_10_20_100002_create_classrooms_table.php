<?php

use App\Models\System\Users\User;
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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->json('full_description')->nullable();
            $table->string('classroom_type')->nullable()->comment('lab, library, sports, classroom, technology, etc.');
            $table->json('location')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room_number')->nullable();
            $table->integer('capacity')->nullable()->comment('Maximum student capacity');
            $table->json('equipment')->nullable()->comment('List of equipment/facilities');
            $table->json('features')->nullable()->comment('Special features');
            $table->json('schedule')->nullable()->comment('Usage schedule');
            $table->json('metadata')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};

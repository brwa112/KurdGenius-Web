<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            if (!Schema::hasColumn('campuses', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('content');
            }
        });

        Schema::table('classrooms', function (Blueprint $table) {
            if (!Schema::hasColumn('classrooms', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('content');
            }
        });

        // Backfill existing campuses
        $campuses = DB::table('campuses')->select('id', 'title', 'slug')->get();
        foreach ($campuses as $campus) {
            if (empty($campus->slug)) {
                $title = '';
                try {
                    $decoded = json_decode($campus->title, true);
                    if (is_array($decoded)) {
                        $title = $decoded['en'] ?? reset($decoded) ?? '';
                    }
                } catch (Throwable $e) {
                    $title = '';
                }
                $generated = Str::slug(trim($title) . '-' . $campus->id);
                DB::table('campuses')->where('id', $campus->id)->update(['slug' => $generated]);
            }
        }

        // Backfill existing classrooms
        $classrooms = DB::table('classrooms')->select('id', 'title', 'slug')->get();
        foreach ($classrooms as $classroom) {
            if (empty($classroom->slug)) {
                $title = '';
                try {
                    $decoded = json_decode($classroom->title, true);
                    if (is_array($decoded)) {
                        $title = $decoded['en'] ?? reset($decoded) ?? '';
                    }
                } catch (Throwable $e) {
                    $title = '';
                }
                $generated = Str::slug(trim($title) . '-' . $classroom->id);
                DB::table('classrooms')->where('id', $classroom->id)->update(['slug' => $generated]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            if (Schema::hasColumn('campuses', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
        });

        Schema::table('classrooms', function (Blueprint $table) {
            if (Schema::hasColumn('classrooms', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
        });
    }
};

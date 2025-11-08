<?php

use App\Models\Pages\Branch;
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
        // Add branch_id to academic_approaches
        Schema::table('academic_approaches', function (Blueprint $table) {
            $table->foreignIdFor(Branch::class)->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        // Add branch_id to academic_chooses
        Schema::table('academic_chooses', function (Blueprint $table) {
            $table->foreignIdFor(Branch::class)->nullable()->after('user_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove branch_id from academic_approaches
        Schema::table('academic_approaches', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        // Remove branch_id from academic_chooses
        Schema::table('academic_chooses', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};

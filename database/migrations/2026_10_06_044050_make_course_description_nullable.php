<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->text('description')->nullable()->change();
        });
    }

    public function down(): void
    {
        if (DB::table('courses')->whereNull('description')->exists()) {
            throw new RuntimeException('Fill missing course descriptions before rolling back this migration.');
        }

        Schema::table('courses', function (Blueprint $table): void {
            $table->text('description')->nullable(false)->change();
        });
    }
};

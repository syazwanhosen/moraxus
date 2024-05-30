<?php

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
        Schema::table('modules', function (Blueprint $table) {
            $table->string('file_name')->nullable()->change();
            $table->string('file_path')->nullable()->change();
            $table->string('file_type')->nullable()->change();
            $table->string('video_name')->nullable()->change();
            $table->string('video_path')->nullable()->change();
            $table->string('video_type')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            
            $table->string('file_name')->nullable(false)->change();
            $table->string('file_path')->nullable(false)->change();
            $table->string('file_type')->nullable(false)->change();
            $table->string('video_name')->nullable(false)->change();
            $table->string('video_path')->nullable(false)->change();
            $table->string('video_type')->nullable(false)->change();

        });
    }
};

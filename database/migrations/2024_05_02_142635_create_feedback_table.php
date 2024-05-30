<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->text('created_by'); // Assuming 'created_by' is a foreign key to users table
            $table->timestamps(); // This will create 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}


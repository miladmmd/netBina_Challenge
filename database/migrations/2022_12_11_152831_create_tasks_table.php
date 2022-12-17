<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('confirmed_by')->nullable()->references('id')->on('users');
            $table->foreignId('last_assigned_user_id')->nullable()->references('id')->on('users');
            $table->string('title');
            $table->timestamp('deadline')->nullable();
            $table->enum('status', ['pending', 'delayed','confirm'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->boolean('agree')->default(false);
            $table->foreignId('branche_id')->constrained('branches')->onDelete('cascade');
            $table->date('day');
            $table->enum('type', ['morning', 'midday', 'afternoon']);
            $table->enum('category', ['one_time', 'weekly', 'bi_weekly', 'monthly'])->default('one_time');
            $table->enum('subcategory', ['basic', 'deep', 'steam', 'move'])->default('basic');
            $table->integer('square');
            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();
            $table->integer('carpet')->nullable();
            $table->json('interior')->nullable();
            $table->double('price');
            $table->string('address');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->boolean('tc')->default(false)->comment('terms and conditions');
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'failed'])->default('unpaid');


            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

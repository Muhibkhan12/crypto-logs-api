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
        Schema::create('add_trade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('coin');
            $table->enum('type',['buy','sell']);
            $table->decimal('entry_price',12,2);
            $table->integer('quantity');
            $table->enum('status',['open','closed'])->default('open');
            $table->timestamp('opened_at');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_trade');
    }
};

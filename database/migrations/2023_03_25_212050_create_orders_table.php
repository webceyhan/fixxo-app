<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('url')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('cost')->default(0);
            $table->string('note')->nullable();
            $table->enum('status', OrderStatus::values())->default(OrderStatus::NEW);
            $table->timestamps();

            // index definitions
            $table->fullText(['name', 'url', 'note']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount')->default(0);
            $table->enum('type', PaymentType::values())->default(PaymentType::CHARGE);
            $table->enum('method', PaymentMethod::values())->default(PaymentMethod::CASH);
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `payments` ADD FULLTEXT KEY `search` (`notes`)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

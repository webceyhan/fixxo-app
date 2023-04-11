<?php

use App\Enums\TicketStatus;
use App\Models\Ticket;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('note')->nullable();
            $table->enum('status', TicketStatus::values())->default(TicketStatus::NEW->value);
            $table->timestamps();

            // aggregate fields
            $table->decimal('balance')->default(0);
            $table->integer('completed_tasks_count')->default(0);
            $table->integer('total_tasks_count')->default(0);
            $table->integer('received_orders_count')->default(0);
            $table->integer('total_orders_count')->default(0);

            // index definitions
            $table->fullText(Ticket::fullTextColumns());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

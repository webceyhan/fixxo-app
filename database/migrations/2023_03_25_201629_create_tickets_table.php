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
            // TODO: maybe add customer_id field istead of through device?
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('note')->nullable();
            // aggregate fields
            // TODO: maybe move to separate table?
            $table->decimal('balance')->default(0);
            // TODO: add total task/order cost fields
            // TODO: add total paid field
            $table->integer('completed_tasks_count')->default(0);
            $table->integer('total_tasks_count')->default(0);
            $table->integer('received_orders_count')->default(0);
            $table->integer('total_orders_count')->default(0);
            // ----------------
            $table->enum('status', TicketStatus::values())->default(TicketStatus::NEW->value);
            $table->timestamps();

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

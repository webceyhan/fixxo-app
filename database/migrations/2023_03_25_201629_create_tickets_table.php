<?php

use App\Enums\Priority;
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
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->enum('priority', Priority::values())->default(Priority::Normal);
            $table->enum('status', TicketStatus::values())->default(TicketStatus::New);
            $table->date('due_date');
            $table->timestamps();

            // aggregate fields
            $table->decimal('balance')->default(0);
            $table->integer('total_tasks_count')->default(0);
            $table->integer('completed_tasks_count')->default(0);
            $table->integer('total_orders_count')->default(0);
            $table->integer('completed_orders_count')->default(0);

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

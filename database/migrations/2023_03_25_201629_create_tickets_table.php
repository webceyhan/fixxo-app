<?php

use App\Enums\TicketStatus;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('note')->nullable();
            $table->decimal('balance')->default(0);
            $table->integer('completed_task_count')->default(0);
            $table->integer('total_task_count')->default(0);
            $table->enum('status', TicketStatus::values())->default(TicketStatus::NEW);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `tickets` ADD FULLTEXT KEY `search` (`description`)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

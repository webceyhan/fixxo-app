<?php

use App\Enums\DeviceStatus;
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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('serial')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expire_date')->nullable();
            // aggregate fields
            $table->integer('inprogress_tickets_count')->default(0);
            $table->integer('onhold_tickets_count')->default(0);
            $table->integer('resolved_tickets_count')->default(0);
            $table->integer('closed_tickets_count')->default(0);
            $table->integer('total_tickets_count')->default(0);
            // ----------------
            $table->enum('status', DeviceStatus::values())->default(DeviceStatus::CHECKED_IN);
            $table->timestamps();

            // index definitions
            $table->fullText(['name', 'brand', 'type', 'serial']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

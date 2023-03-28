<?php

use App\Enums\DeviceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            // aggregations
            $table->integer('closed_tickets_count')->default(0);
            $table->integer('total_tickets_count')->default(0);
            //
            $table->enum('status', DeviceStatus::values())->default(DeviceStatus::CHECKED_IN);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `devices` ADD FULLTEXT KEY `search` (`name`,`brand`,`type`,`serial`)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

<?php

use App\Enums\AssetStatus;
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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('serial')->nullable();
            $table->date('purchase_date')->nullable();
            $table->tinyInteger('warranty')->default(0);
            $table->string('problem')->nullable();
            $table->string('notes')->nullable();
            $table->enum('status', AssetStatus::values())->default(AssetStatus::IN_PROGRESS);
            $table->timestamps();
            $table->timestamp('returned_at')->nullable();
        });

        DB::statement('ALTER TABLE `assets` ADD FULLTEXT KEY `search` (`name`,`serial`,`problem`)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};

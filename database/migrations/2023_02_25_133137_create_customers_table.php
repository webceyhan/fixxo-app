<?php

use App\Models\Customer;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('vat')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            // TODO: use soft deletes later

            // aggregate fields
            $table->decimal('balance')->default(0);
            $table->integer('closed_tickets_count')->default(0);
            $table->integer('total_tickets_count')->default(0);

            // index definitions
            $table->fullText(Customer::fullTextColumns());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

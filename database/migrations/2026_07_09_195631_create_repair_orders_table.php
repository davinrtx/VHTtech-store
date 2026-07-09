<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('device_type');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->text('issue_description');
            $table->text('diagnosed_problem')->nullable();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', [
                'received', 'in_diagnosis', 'quote_pending', 'in_repair', 'ready', 'delivered', 'cancelled',
            ])->default('received');
            $table->decimal('estimated_cost', 10, 2)->default(0);
            $table->decimal('final_cost', 10, 2)->default(0);
            $table->integer('warranty_months')->nullable();
            $table->timestamp('received_at')->useCurrent();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_orders');
    }
};
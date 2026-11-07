<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $t) {
            $t->id(); $t->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $t->string('coin', 10); $t->string('txid')->unique(); $t->decimal('amount_usd', 10, 2)->default(0);
            $t->string('status')->default('pending')->index(); $t->timestamp('verified_at')->nullable(); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};

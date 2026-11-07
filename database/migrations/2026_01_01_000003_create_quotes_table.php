<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $t) {
            $t->id(); $t->string('token', 64)->unique();
            $t->string('name'); $t->string('email')->index(); $t->string('country'); $t->string('city');
            $t->text('idea'); $t->string('style'); $t->string('placement'); $t->string('size'); $t->string('color');
            $t->string('timeframe')->nullable(); $t->unsignedInteger('budget')->nullable(); $t->boolean('consultation')->default(false);
            $t->foreignId('artist_id')->nullable()->constrained()->nullOnDelete();
            $t->string('reference')->nullable(); $t->string('status')->default('new')->index();
            $t->decimal('price', 10, 2)->nullable(); $t->decimal('deposit', 10, 2)->nullable();
            $t->text('admin_note')->nullable(); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('quotes'); }
};

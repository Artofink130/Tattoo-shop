<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $t) {
            $t->timestamp('studio_notified_at')->nullable();
            $t->text('mail_error')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('quotes', fn (Blueprint $t) => $t->dropColumn(['studio_notified_at', 'mail_error']));
    }
};

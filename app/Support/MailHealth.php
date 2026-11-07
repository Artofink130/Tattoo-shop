<?php
namespace App\Support;

use App\Services\StudioMailer;

/** Detects mail settings that silently prevent the studio from receiving request emails. */
class MailHealth
{
    /** First configuration problem, or null when everything looks fine. */
    public static function problem(): ?string
    {
        return self::problems()[0] ?? null;
    }

    /** @return string[] */
    public static function problems(): array
    {
        return app(StudioMailer::class)->problems();
    }
}

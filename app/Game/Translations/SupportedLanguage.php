<?php

namespace App\Game\Translations;

enum SupportedLanguage: string
{
    case EN = 'English';
    case ES = 'Spanish';

    public function laravelLocale(): string
    {
        return match ($this) {
            self::ES => 'es',
            self::EN => 'en',
        };
    }
}

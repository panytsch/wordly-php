<?php

namespace App\Game\Translations;

interface TranslatorInterface
{
    public function translate(TranslationKey $key): string;
}

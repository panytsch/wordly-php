<?php

namespace App\Game\Translations;

interface Translator
{
    public function translate(TranslationKey $key): string;
}

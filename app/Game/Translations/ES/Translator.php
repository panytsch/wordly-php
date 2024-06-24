<?php

namespace App\Game\Translations\ES;

use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;

class Translator implements TranslatorInterface
{

    public function __construct(private TranslatorInterface $fallbackTranslator)
    {
    }

    public function translate(TranslationKey $key): string
    {
        $translated = $this->getTranslation($key);

        if ($translated === null) {
            return $this->fallbackTranslator->translate($key);
        }

        return $translated;
    }

    private function getTranslation(TranslationKey $key): ?string
    {
        return match ($key) {
            TranslationKey::CHOSE_LANG    => 'Elige tu idioma',
            TranslationKey::STARTING_GAME => '¡Comencemos el juego! Pulse Intro para continuar',
            TranslationKey::FETCHING_WORD => 'Introduce tu idioma',
            TranslationKey::SAVE_PROGRESS => '¿Quieres guardar tu progreso?',
            TranslationKey::LOAD_PROGRESS => '¿Quieres recuperar tu progreso?',
            TranslationKey::PREV_GUESSES  => "Tus conjeturas anteriores.\nFondo blanco: la letra existe pero en otra posición, verde: posición correcta",
            TranslationKey::GUESS_WORD    => 'Ingresa tu palabra:',
            TranslationKey::WIN           => '¡Has ganado!',
            TranslationKey::LOSE          => '¡Has perdido!',
            TranslationKey::WANT_RETRY    => '¿Quieres volver a jugar?',
            default                       => null,
        };
    }
}

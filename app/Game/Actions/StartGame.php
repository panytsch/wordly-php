<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\Translator;
use Laravel\Prompts\Prompt;
use function Laravel\Prompts\pause;

class StartGame implements Action
{


    public function __construct(private Translator $translator)
    {
    }

    public function run(): void
    {
        IO::clearConsole();
        pause($this->translator->translate(TranslationKey::STARTING_GAME));

        $this->runNextAction();
    }

    private function runNextAction()
    {
    }
}

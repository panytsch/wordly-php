<?php

namespace App\Game\Actions;

use App\Game\State\Save;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\Translator;
use function Laravel\Prompts\confirm;

class LoadSave implements Action
{

    public function __construct(
        private Save            $save,
        private StartGame       $startGame,
        private GuessWordAction $guessWordAction,
        private Translator      $translator,
    )
    {
    }

    public function run(): void
    {
        if (!$this->save->saveExists()) {
            $this->startGame->run();
            return;
        }

        $wantRestoreGame = confirm($this->translator->translate(TranslationKey::LOAD_PROGRESS));
        if (!$wantRestoreGame) {
            $this->save->delete();
            $this->startGame->run();
        }

        $this->save->restore();
        $this->guessWordAction->run();
    }
}

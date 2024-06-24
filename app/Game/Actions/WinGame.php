<?php

namespace App\Game\Actions;

use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslatorInterface;

class WinGame implements Action
{

    public function __construct(
        private AutoSavingState     $state,
        private TranslatorInterface $translator
    )
    {
    }

    public function run(): void
    {
    }
}

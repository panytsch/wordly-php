<?php

namespace App\Game\WordProviders;

interface WordProviderInterface
{
    public function word(int $length): string;

    public function setProvider(WordProviderInterface $provider);
}

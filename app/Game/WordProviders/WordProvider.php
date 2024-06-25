<?php

namespace App\Game\WordProviders;

class WordProvider implements WordProviderInterface
{
    private WordProviderInterface $provider;

    public function word(int $length): string
    {
        return $this->provider->word($length);
    }

    public function setProvider(WordProviderInterface $provider): void
    {
        $this->provider = $provider;
    }
}

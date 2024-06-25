<?php

namespace App\Game\WordProviders;

use GuzzleHttp\Client;

class EnglishWordProvider implements WordProviderInterface
{

    public function __construct(private Client $client)
    {
    }

    public function word(int $length): string
    {
        $uri = 'https://random-word.ryanrk.com/api/en/word/random/';
        $response = $this->client->get(
            $uri,
            [
                'verify' => false,
                'query'  => [
                    'length' => $length,
                ],
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);

        return $decoded[0];
    }

    public function setProvider(WordProviderInterface $provider)
    {
    }
}

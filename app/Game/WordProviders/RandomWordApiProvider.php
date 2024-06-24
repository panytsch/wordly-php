<?php

namespace App\Game\WordProviders;

use GuzzleHttp\Client;

class RandomWordApiProvider
{

    public function __construct(private Client $client)
    {
    }

    public function spanishWord(int $length): string
    {
        $uri = "https://random-word-api.herokuapp.com/word";
        $response = $this->client->get(
            $uri,
            [
                'verify' => false,
                'query'  => [
                    'length'   => $length,
                    'lang' => 'es',
                ],
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);

        return $decoded[0];
    }

    public function englishWord(int $length): string
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
}

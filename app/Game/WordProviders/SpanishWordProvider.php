<?php

namespace App\Game\WordProviders;

use GuzzleHttp\Client;

class SpanishWordProvider implements WordProviderInterface
{

    public function __construct(private Client $client)
    {
    }

    public function word(int $length): string
    {
        $uri = "https://random-word-api.herokuapp.com/word";
        $response = $this->client->get(
            $uri,
            [
                'verify' => false,
                'query'  => [
                    'length' => $length,
                    'lang'   => 'es',
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

<?php

namespace App\Services\Todo\ImportManager\Clients;

use App\Dto\TodoWorkList\Importer\Client\TodoClientData;
use App\Services\Todo\ImportManager\TodoClient;
use GuzzleHttp\Client;

class TodoMockTwoClient implements TodoClient
{
    public function __construct(
        public Client $client,
    ) {
    }

    public function fetch(): array
    {
        $response = $this->client->get('https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-two');

        $todos = json_decode($response->getBody(), true);

        return array_map(
            function ($todoData) {
                return new TodoClientData(
                    id: $todoData['id'],
                    difficultyLevel: $todoData['zorluk'],
                    estimatedDuration: $todoData['sure'],
                );
            },
            $todos
        );
    }
}

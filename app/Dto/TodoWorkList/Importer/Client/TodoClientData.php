<?php

namespace App\Dto\TodoWorkList\Importer\Client;

class TodoClientData
{
    public function __construct(
        public int $id,
        public int $difficultyLevel,
        public int $estimatedDuration,
    ) {
    }
}

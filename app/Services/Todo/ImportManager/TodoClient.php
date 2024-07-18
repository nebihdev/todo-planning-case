<?php

namespace App\Services\Todo\ImportManager;

use App\Dto\TodoWorkList\Importer\Client\TodoClientData;

interface TodoClient
{
    /**
     * @return array<TodoClientData>
     */
    public function fetch(): array;
}

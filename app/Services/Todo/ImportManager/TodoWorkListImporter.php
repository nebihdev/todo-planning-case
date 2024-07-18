<?php

namespace App\Services\Todo\ImportManager;

use App\Dto\TodoWorkList\Importer\Client\TodoClientData;
use App\Models\Task;

class TodoWorkListImporter
{
    public function import(): void
    {
        $todoImportClients = config('services.todo.importer.clients');

        try {
            \DB::beginTransaction();

            foreach ($todoImportClients as $todoImportClient) {
                /** @var TodoClient $todoClient */
                $todoClient = app($todoImportClient);
                $todoClientDataList = $todoClient->fetch();

                foreach ($todoClientDataList as $todoClientData) {
                    $this->createTask($todoClientData);
                }
            }

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();

            throw $e;
        }
    }

    private function createTask(TodoClientData $todoClientData): void
    {
        $task = new Task();
        $task->name = $this->generateTaskName($todoClientData);
        $task->estimated_duration = $todoClientData->estimatedDuration;
        $task->difficulty_level = $todoClientData->difficultyLevel;
        $task->save();
    }

    private function generateTaskName(TodoClientData $todoClientData): string
    {
        $randomStr = \Str::random(5);

        return "Task {$todoClientData->id} - $randomStr";
    }
}

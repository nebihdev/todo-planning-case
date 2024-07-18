<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use Carbon\Carbon;

class SprintManager
{
    public function getCurrentSprintOrCreateNew(): Sprint
    {
        $now = now();

        return Sprint::query()
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first() ?? $this->createSprint();
    }

    public function createSprint(?Carbon $startDate = null): Sprint
    {
        $startDate = ($startDate ?? now())->startOfDay();

        $sprint = new Sprint();
        $sprint->name = $this->generateSprintName();
        $sprint->start_date = $startDate;
        $sprint->end_date = $startDate->addDays($this->getSprintDurationInDays() - 1);
        $sprint->save();

        return $sprint;
    }

    private function generateSprintName(): string
    {
        $sprintCount = Sprint::query()->count();

        return 'Sprint '.++$sprintCount;
    }

    private function getSprintDurationInDays(): int
    {
        return config('services.todo.sprint_planning.sprint_duration_in_days');
    }
}

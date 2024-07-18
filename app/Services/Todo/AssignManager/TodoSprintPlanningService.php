<?php

namespace App\Services\Todo\AssignManager;

use App\Models\Developer;
use App\Models\Sprint;
use App\Models\Task;
use App\Services\Sprint\SprintManager;

class TodoSprintPlanningService
{
    public function __construct(
        public SprintManager $sprintManager,
    ) {
    }

    public function assignTasksToDevelopers(?Sprint $currentSprint = null): void
    {
        $tasks = Task::query()
            ->scopes(['unassigned'])
            ->orderByDesc('difficulty_level')
            ->orderByDesc('estimated_duration')
            ->get();

        $developers = Developer::query()
            ->orderByDesc('max_difficulty_level')
            ->get();

        if ($tasks->isEmpty()) {
            throw new \Exception('There is no task to assign.');
        }

        if ($developers->isEmpty()) {
            throw new \Exception('There is no developer to assign.');
        }

        $remainingEffortsForSprintByDeveloper = $developers->mapWithKeys(function (Developer $developer) {
            return [$developer->id => $this->getWeeklyWorkTime()];
        });

        // Not: Bu aşamada sprintin oluşturulmadığı varsayılarak hareket edildi.
        $currentSprint = $this->sprintManager->createSprint($currentSprint?->end_date?->addDay());

        foreach ($tasks as $task) {
            foreach ($remainingEffortsForSprintByDeveloper->sortDesc() as $developerId => $remainingEffort) {
                $developer = $developers->firstWhere('id', $developerId);

                $developerEffortForTask = $this->calculateDeveloperCompleteDurationByTask($task, $developer);

                // Developer'ın bu task'ı yapabilmesi için yeterli zamanı var mı?
                if ($remainingEffortsForSprintByDeveloper[$developer->id] > $developerEffortForTask) {
                    $this->assignTaskToDeveloperForCurrentSprint($task, $developer, $currentSprint);

                    $remainingEffortsForSprintByDeveloper[$developer->id] -= $developerEffortForTask;

                    break;
                }
            }
        }

        $stillUnassignedTasksExists = Task::query()
            ->scopes(['unassigned'])
            ->limit(1)
            ->exists();

        if ($stillUnassignedTasksExists) {
            $this->assignTasksToDevelopers();
        }
    }

    public function calculateDeveloperCompleteDurationByTask(Task $task, Developer $developer): int
    {
        return ceil(($developer->max_difficulty_level / $task->difficulty_level) * $task->estimated_duration);
    }

    private function assignTaskToDeveloperForCurrentSprint(Task $task, Developer $developer, Sprint $sprint): void
    {
        $task->sprint_id = $sprint->id;
        $task->assigned_developer_id = $developer->id;
        $task->save();
    }

    /**
     * Haftalık developer çalışma süresi (saat cinsinden).
     */
    private function getWeeklyWorkTime(): int
    {
        return config('services.todo.sprint_planning.weekly_total_work_time');
    }
}

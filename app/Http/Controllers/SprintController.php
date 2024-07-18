<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Services\Todo\AssignManager\TodoSprintPlanningService;

class SprintController extends Controller
{
    public function index(TodoSprintPlanningService $todoSprintPlanningService)
    {
        $sprints = Sprint::query()
            ->with([
                'tasks.assignedDeveloper',
            ])
            ->get();

        $sprints->map(function (Sprint $sprint) use ($todoSprintPlanningService) {
            $sprint->takenHoursToFinishTasks = 0;

            return $sprint->tasks->map(function ($task) use ($sprint, $todoSprintPlanningService) {
                $effort = $todoSprintPlanningService->calculateDeveloperCompleteDurationByTask($task, $task->assignedDeveloper);

                $task->estimated_duration_for_assigned_developer = $effort;
                $sprint->takenHoursToFinishTasks += $effort;
            });
        });

        return view('sprints.index')->with([
            'sprints' => $sprints,
        ]);
    }
}

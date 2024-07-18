<?php

namespace App\Console\Commands\Todo;

use App\Models\Sprint;
use App\Models\Task;
use App\Services\Todo\AssignManager\TodoSprintPlanningService;
use Illuminate\Console\Command;

class AssignTasksToDevelopersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-tasks-to-developers-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tüm boştaki taskleri developerlara sprint oluşturarak atama işlemi yapar.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Task::query()->update(['assigned_developer_id' => null, 'sprint_id' => null]);
        Sprint::query()->delete();
        $this->line('Önceden oluşturulan tüm sprintler silindi.');

        $todoSprintPlanningService = app()->make(TodoSprintPlanningService::class);

        $this->line('AssignTasksToDevelopersCommand çalıştırılıyor... İşlem biraz uzun sürebilir, lütfen bekleyiniz.');
        $todoSprintPlanningService->assignTasksToDevelopers();

        $this->info('AssignTasksToDevelopersCommand çalıştırıldı.');

        return self::SUCCESS;
    }
}

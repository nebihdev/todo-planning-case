<?php

namespace App\Console\Commands\Todo;

use Illuminate\Console\Command;

class TodoWorkListImporterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:todo-work-list-importer-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tüm Providerlardan iş listesini çekerek veritabanına kaydeder.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $todoWorkListImporter = app(\App\Services\Todo\ImportManager\TodoWorkListImporter::class);

        $this->line('TodoWorkListImporterCommand çalıştırılıyor... İşlem biraz uzun sürebilir, lütfen bekleyiniz.');
        $todoWorkListImporter->import();

        $this->info('TodoWorkListImporterCommand çalıştırıldı.');

        return self::SUCCESS;
    }
}

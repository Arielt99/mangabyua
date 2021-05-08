<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class dev_environment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev {Mangakas=10} {Readers=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'setting dev environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $this->info("\033[36m DEV ENVIRONMENT CREATION");

        //default values
        $nbMangaka = $this->argument('Mangakas');
        $nbReader = $this->argument('Readers');

        //migrate
        $this->info("\033[33m Starting migrating...");
        Artisan::call('migrate:fresh');
        $this->info("\033[32m Default migration done \xE2\x9C\x94");

        //seed
        $this->info("\033[33m Starting seeding...");
        Artisan::call('db:seed');
        $this->info("\033[32m Seeding done \xE2\x9C\x94");

        $this->info("\033[33m Starting creating ".($nbMangaka+$nbReader)." users...");

        //Mangakas creation
        $this->info("\033[33m --- Creating ".$nbMangaka." Mangakas :");
        $bar = $this->output->createProgressBar($nbMangaka);
        $bar->setFormat(' --- %bar% %percent:3s%% %current%/%max%');
        $bar->setBarCharacter('<comment>█</comment>');
        $bar->setEmptyBarCharacter(' ');
        $bar->setProgressCharacter(' ');
        $bar->start();

        $mangakaRole = Role::findOrCreate('Mangaka');

        for ($i=0; $i < $nbMangaka; $i++) {
            /** @var User $user */
            $user = User::factory()
                ->create([
                    'email' => 'mangaka-' . $i . '@example.com',
                ])
                ->assignRole($mangakaRole);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\n\033[97m --- Mangakas created\xE2\x9C\x94");

        //Readers creation
        $this->info("\033[33m --- Creating ".$nbReader." Readers :");
        $bar = $this->output->createProgressBar($nbReader);
        $bar->setFormat(' --- %bar% %percent:3s%% %current%/%max%');
        $bar->setBarCharacter('<comment>█</comment>');
        $bar->setEmptyBarCharacter(' ');
        $bar->setProgressCharacter(' ');
        $bar->start();

        $readerRole = Role::findOrCreate('Reader');

        for ($i=0; $i < $nbReader; $i++) {
            /** @var User $user */
            $user = User::factory()
                ->create([
                    'email' => 'reader-' . $i . '@example.com',
                ])
                ->assignRole($readerRole);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\n\033[97m --- Readers created\xE2\x9C\x94");
        
        $this->info("\033[32m All users are created \xE2\x9C\x94");

        //time taken to do the action
        $this->info("\033[35m Action completed in ".round((microtime(true) - $start), 4)." seconds");

    }
}

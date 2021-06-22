<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class devEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev {Mangakas=0} {Readers=0} {Tags=0} {Mangas=0} {Chapters=0}';

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
        $asciiLogo = "
        ___  ___                        _
        |  \/  |                       | |
        | .  . | __ _ _ __   __ _  __ _| |__  _   _ _   _  __ _
        | |\/| |/ _` | '_ \ / _` |/ _` | '_ \| | | | | | |/ _` |
        | |  | | (_| | | | | (_| | (_| | |_) | |_| | |_| | (_| |
        \_|  |_/\__,_|_| |_|\__, |\__,_|_.__/ \__, |\__,_|\__,_|
                             __/ |             __/ |
                            |___/             |___/
        ";

        $start = microtime(true);

        $this->info("\033[0;91m ".$asciiLogo);

        $this->info("\033[1;36m DEV ENVIRONMENT CREATION");

        //command values
        $nbMangaka = $this->argument('Mangakas');
        $nbReader = $this->argument('Readers');
        $nbTag = $this->argument('Tags');
        $nbManga = $this->argument('Mangas');
        $nbChapter = $this->argument('Chapters');

        //optimize
        $this->info("\033[0;33m Starting optimization...");
        Artisan::call('clear-compiled');
        Artisan::call('optimize');
        $this->info("\033[32m Optimization done \xE2\x9C\x94");

        //db wipe
        $this->info("\033[33m Starting db wipe...");
        Artisan::call('db:wipe');
        $this->info("\033[32m DB wipe done \xE2\x9C\x94");

        //migrate
        $this->info("\033[0;33m Starting migrating...");
        Artisan::call('migrate:fresh');
        $this->info("\033[32m Default migration done \xE2\x9C\x94");

        //seed
        $this->info("\033[33m Starting seeding...");
        Artisan::call('db:seed');
        $this->info("\033[32m Seeding done \xE2\x9C\x94");

        /**
         * Users creation block
         */
        if($nbMangaka+$nbReader > 0){
            $this->info("\033[33m Starting creating ".($nbMangaka+$nbReader)." users...");

            //Mangakas creation
            if($nbMangaka > 0){
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
            }

            //Readers creation
            if($nbReader > 0){
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
            }

            $this->info("\033[32m All users are created \xE2\x9C\x94");
        }

        //tags creations
        if($nbTag > 0){
            $this->info("\033[33m Starting creating ".($nbTag)." tags...");
            $bar = $this->output->createProgressBar($nbTag);
            $bar->setFormat('%bar% %percent:3s%% %current%/%max%');
            $bar->setBarCharacter('<comment>█</comment>');
            $bar->setEmptyBarCharacter(' ');
            $bar->setProgressCharacter(' ');
            $bar->start();

            for ($i=0; $i < $nbTag; $i++) {
                /** @var Tag $tag */
                $tag = Tag::factory()
                    ->create();

                $bar->advance();
            }
            $bar->finish();
            $this->info("\n\033[32m All tags are created \xE2\x9C\x94");
        }

        //mangas creations
        if($nbManga > 0){
            $this->info("\033[33m Starting creating ".($nbManga)." mangas...");
            $bar = $this->output->createProgressBar($nbManga);
            $bar->setFormat('%bar% %percent:3s%% %current%/%max%');
            $bar->setBarCharacter('<comment>█</comment>');
            $bar->setEmptyBarCharacter(' ');
            $bar->setProgressCharacter(' ');
            $bar->start();

            $mangakas = User::query()->whereRoleIsMangaka()->get();
            $tags = Tag::query()->get();

            for ($i=0; $i < $nbManga; $i++) {
                /** @var Tag $tag */
                $manga = Manga::factory()
                    ->create();

                $manga->mangakas()->sync($mangakas->random(rand(1,2))->pluck('id'));

                $manga->tags()->sync($tags->random(rand(1,5))->pluck('id'));

                if($manga->tags()->where('isMature', true)->exists()){
                    $manga->isMature = true;
                    $manga->save();
                }

                $bar->advance();
            }
            $bar->finish();
            $this->info("\n\033[32m All mangas are created \xE2\x9C\x94");
        }

        //chapters creations
        if($nbChapter > 0){
            $this->info("\033[33m Starting creating ".($nbChapter)." chapters...");
            $bar = $this->output->createProgressBar($nbChapter);
            $bar->setFormat('%bar% %percent:3s%% %current%/%max%');
            $bar->setBarCharacter('<comment>█</comment>');
            $bar->setEmptyBarCharacter(' ');
            $bar->setProgressCharacter(' ');
            $bar->start();


            for ($i=0; $i < $nbChapter; $i++) {
                /** @var Chapter $chapter */
                $chapter = Chapter::factory()
                    ->create();

                $bar->advance();
            }
            $bar->finish();
            $this->info("\n\033[32m All chapters are created \xE2\x9C\x94");
        }

        //time taken to do the action
        $this->info("\033[35m Action completed in ".round((microtime(true) - $start), 4)." seconds");

    }
}

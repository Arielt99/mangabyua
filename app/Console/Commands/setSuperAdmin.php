<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class setSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        /** @var User $user */
        $user = User::where('email', $email = $this->argument('email'))
        ->firstOrFail();

         try {
             $user->assignRole('Super-Admin');

             $this->info('User ' . $email . ' is now admin.');
         } catch (RoleDoesNotExist $roleDoesNotExist) {
             $this->info('Role does not exist, please seed.');
         }
    }
}

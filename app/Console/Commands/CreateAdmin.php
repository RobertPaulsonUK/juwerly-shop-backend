<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
          'email' => 'test@gmail.com',
          'password' => Hash::make('qwert12345'),
          'name' => 'admin',
          'role' => 'admin',
            'email_verified_at' => Carbon::now()
        ];
        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            $this->error("User with email {$data['email']} already exists.");
            return;
        }

        $user = User::create($data);

        if ($user) {
            $this->info("Admin user created successfully!");
            $this->info("Email: {$data['email']}");
        } else {
            $this->error("Failed to create admin user.");
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            
            if ($this->confirm('Would you like to create a new admin user?')) {
                $name = $this->ask('Enter the name');
                $password = $this->secret('Enter the password (min 8 characters)');
                
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                ]);
                
                $this->info("Admin user created successfully!");
                $this->info("Email: {$user->email}");
                $this->info("You can now login with this account.");
                return 0;
            }
            
            return 1;
        }
        
        $user->role = 'admin';
        $user->save();
        
        $this->info("User '{$user->name}' ({$user->email}) is now an admin!");
        
        return 0;
    }
}

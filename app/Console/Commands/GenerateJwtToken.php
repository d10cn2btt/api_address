<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;


class GenerateJwtToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate_jwt_token {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get jwt token';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            if (!empty($userId = $this->argument('user'))) {
                $user = User::find($userId);
            } else {
                $user = User::inRandomOrder()->first();
            }

            if (empty($user)) {
                throw new \Exception('User not found');
            }

            echo JWTAuth::fromUser($user);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}

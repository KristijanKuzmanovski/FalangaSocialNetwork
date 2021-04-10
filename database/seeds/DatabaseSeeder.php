<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersSeeder::class);
         $this->call(MessagesSeeder::class);
         $this->call(CommentsSeeder::class);
         $this->call(VotesSeeder::class);
         $this->call(PostsSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     private $user;
     public function __construct(User $user){
        $this->user = $user;
     }
     public function run()
     {
         $users = [
             [
                 'name' => 'TestUser',
                 'email' => 'test@test',
                 'password' => Hash::make('aaaaaaaa'),
                 'role_id' => '2',
                 'created_at' => NOW(),
                 'updated_at' => NOW(),
             ],
             [
                'name' => 'TestUser2',
                'email' => 'test2@test',
                'password' => Hash::make('aaaaaaaa'),
                'role_id' => '2',
                'created_at' => NOW(),
                'updated_at' => NOW(),
             ],
             [
                'name' => 'TestUser3',
                'email' => 'test3@test',
                'password' => Hash::make('aaaaaaaa'),
                'role_id' => '2',
                'created_at' => NOW(),
                'updated_at' => NOW(),
             ]
         ];
 
         //insert() - adds multiple records
         $this->user->insert($users);
     }
}

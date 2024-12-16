<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where(['email'=>'admin@admin.com'])->first();
        if(is_null($user)) {
            User::create([
                'first_name' => "Admin",
                'last_name'  => "Admin",
                'email'      => "admin@admin.com",
                'phone'      => "01000000000",
                'password'   => \Hash::make("admin@1263456"),
                'user_type'  => User::TYPE_ADMIN
            ]);
        } else {
            $user->update([
                'password'   => \Hash::make("admin@1263456"),
                'user_type'  => User::TYPE_ADMIN
            ]);
        }
    }
}

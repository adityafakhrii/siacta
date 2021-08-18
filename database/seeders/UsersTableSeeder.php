<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->nama = "Aditya Fakhri";
        $user->email = "aditya@siacta-desacihideung.com";
        $user->password = bcrypt('pamdes123'); 
        $user->role = "unitusaha";
        $user->id_unitusaha = "1";
        $user->status_neracaawal = NULL;
        $user->save();
    }
}

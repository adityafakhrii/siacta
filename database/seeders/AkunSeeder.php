<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akun = [
            [
                'id_user' => 1,
                'no_akun' => "10.00.00",
                'nama_akun' => "ASET LANCAR",
                'saldo_normal' => "debit",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'id_user' => 1,
                'no_akun' => "11.00.00",
                'nama_akun' => "KAS DAN BANK",
                'saldo_normal' => "debit",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'id_user' => 1,
                'no_akun' => "11.01.00",
                'nama_akun' => "Kas",
                'saldo_normal' => "debit",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'id_user' => 1,
                'no_akun' => "11.02.00",
                'nama_akun' => "Kas di Bank",
                'saldo_normal' => "debit",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'id_user' => 1,
                'no_akun' => "11.03.00",
                'nama_akun' => "Kas kecil",
                'saldo_normal' => "debit",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
        ];

        \DB::table('akuns')->insert($akun);
    }
}

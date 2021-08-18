<?php

namespace Database\Seeders;
use App\Models\Unitusaha;
use Illuminate\Database\Seeder;

class UnitUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitusaha = [
            [
                'jenis' => "Air PAMDes",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'jenis' => "Simpan Pinjam",
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
        ];

        \DB::table('unitusahas')->insert($unitusaha);
    }
}

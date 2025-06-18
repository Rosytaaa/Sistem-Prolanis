<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'=>'Admin',
                'username'=>'operator',
                'role'=>'operator',
                'password'=>bcrypt('adminklinik123')
            ],
            [
                'name'=>'Dokter',
                'username'=>'dokter',
                'role'=>'dokter',
                'password'=>bcrypt('dokter987')
            ],
            [
                'name'=>'Perawat',
                'username'=>'perawat',
                'role'=>'perawat',
                'password'=>bcrypt('perawat987')
            ],
            [
                'name'=>'Pimpinan',
                'username'=>'pimpinan',
                'role'=>'pimpinan',
                'password'=>bcrypt('pimpinan987')
            ]
        ];
        foreach($userData as $key => $val){
            User::create($val);
        }

    }
}

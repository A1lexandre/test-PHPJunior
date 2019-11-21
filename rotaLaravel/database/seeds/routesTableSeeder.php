<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class routesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('routes')->insert([
            'ponto_inicial' => 'A',
            'ponto_final' => 'B',
            'distancia' => 10
        ]);
        DB::table('routes')->insert([
            'ponto_inicial' => 'B',
            'ponto_final' => 'D',
            'distancia' => 15
        ]);
        DB::table('routes')->insert([
            'ponto_inicial' => 'A',
            'ponto_final' => 'C',
            'distancia' => 20
        ]);
        DB::table('routes')->insert([
            'ponto_inicial' => 'C',
            'ponto_final' => 'D',
            'distancia' => 30
        ]);
        DB::table('routes')->insert([
            'ponto_inicial' => 'B',
            'ponto_final' => 'E',
            'distancia' => 50
        ]);
        DB::table('routes')->insert([
            'ponto_inicial' => 'D',
            'ponto_final' => 'E',
            'distancia' => 30
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Factories\UserFactory;
use DB;
class UserVitrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inicial=1;
        for ($i = 0; $i < 5; $i++) {
            // Crear un usuario y obtener su instancia
            $user = (new UserFactory())->create();

            // Usar el ID del usuario recién creado para agregarlo a otra tabla
            DB::table('referidos')->insert([
                'user_id' => $inicial,
                'referred_user_id' => $user->id,  // Agrega aquí los valores necesarios para la otra tabla
            ]);
            $inicial=$user->id;
        }
        
    }
}

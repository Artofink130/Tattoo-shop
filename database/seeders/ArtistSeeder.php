<?php
namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        if (Artist::exists()) return;
        foreach ([
            ['Marina Costa', 'Realism & Portraits', 'São Paulo, BR', 'Photoreal black & grey portraits and large realism pieces.'],
            ['Joaquín Ferrer', 'Fine-Line & Ornamental', 'Buenos Aires, AR', 'Delicate linework, mandalas and ornamental compositions.'],
            ['Kenji Ward', 'Japanese & Large-Scale', 'Los Angeles, US', 'Sleeves, back pieces and Japanese-inspired storytelling.'],
            ['Lia Santos', 'Traditional & Lettering', 'Rio de Janeiro, BR', 'Bold traditional, neo-traditional and custom lettering.'],
        ] as [$name, $specialty, $city, $bio]) {
            Artist::create(compact('name', 'specialty', 'city', 'bio'));
        }
    }
}

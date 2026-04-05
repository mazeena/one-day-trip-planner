<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Attraction;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Create categories
        $categories = [
            ['category_name' => 'Historical'],
            ['category_name' => 'Nature'],
            ['category_name' => 'Religious'],
            ['category_name' => 'Recreational'],
            ['category_name' => 'Cultural'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Sample attractions within 25km of Malwana
        $attractions = [
            [
                'category_id' => 1,
                'name' => 'Colombo National Museum',
                'description' => 'The largest museum in Sri Lanka, housing a vast collection of artifacts and exhibits showcasing the rich cultural heritage of Sri Lanka from ancient times to the modern era.',
                'distance' => 18.5,
                'image' => 'colombo_museum.jpg',
                'location' => 'Colombo 07',
                'latitude' => 6.9102,
                'longitude' => 79.8629,
            ],
            [
                'category_id' => 3,
                'name' => 'Kelaniya Raja Maha Vihara',
                'description' => 'One of the most sacred Buddhist temples in Sri Lanka, believed to have been visited by Lord Buddha himself. The temple features stunning murals and beautiful architecture.',
                'distance' => 8.2,
                'image' => 'kelaniya_temple.jpg',
                'location' => 'Kelaniya',
                'latitude' => 6.9554,
                'longitude' => 79.9220,
            ],
            [
                'category_id' => 2,
                'name' => 'Attidiya Bird Sanctuary',
                'description' => 'A wetland bird sanctuary home to over 100 species of birds including migratory birds. An ideal spot for bird watching and nature photography.',
                'distance' => 22.0,
                'image' => 'attidiya.jpg',
                'location' => 'Dehiwala',
                'latitude' => 6.8428,
                'longitude' => 79.8817,
            ],
            [
                'category_id' => 4,
                'name' => 'Bolgoda Lake',
                'description' => 'The largest natural lake in western Sri Lanka, perfect for boating, fishing, and enjoying scenic views of the surrounding landscape.',
                'distance' => 24.5,
                'image' => 'bolgoda_lake.jpg',
                'location' => 'Moratuwa',
                'latitude' => 6.7800,
                'longitude' => 79.9000,
            ],
            [
                'category_id' => 5,
                'name' => 'Gangaramaya Temple',
                'description' => 'A famous Buddhist temple complex in Colombo featuring a mix of Sri Lankan, Thai, Indian, and Chinese architecture with a museum of eclectic collections.',
                'distance' => 19.0,
                'image' => 'gangaramaya.jpg',
                'location' => 'Colombo 02',
                'latitude' => 6.9168,
                'longitude' => 79.8580,
            ],
            [
                'category_id' => 2,
                'name' => 'Talangama Wetland',
                'description' => 'A beautiful urban wetland teeming with wildlife including water birds, reptiles, and aquatic plants. Popular among nature lovers and photographers.',
                'distance' => 12.0,
                'image' => 'talangama.jpg',
                'location' => 'Talangama',
                'latitude' => 6.9100,
                'longitude' => 79.9400,
            ],
            [
                'category_id' => 1,
                'name' => 'Dutch Hospital Colombo',
                'description' => 'One of the oldest buildings in Colombo, built by the Dutch East India Company. Now a premium shopping precinct with restaurants and boutiques.',
                'distance' => 20.0,
                'image' => 'dutch_hospital.jpg',
                'location' => 'Colombo 01',
                'latitude' => 6.9341,
                'longitude' => 79.8428,
            ],
            [
                'category_id' => 4,
                'name' => 'Viharamahadevi Park',
                'description' => 'The largest and oldest park in Colombo, featuring beautiful gardens, a children\'s play area, an open-air theater, and a golden Buddha statue.',
                'distance' => 18.0,
                'image' => 'viharamahadevi.jpg',
                'location' => 'Colombo 07',
                'latitude' => 6.9147,
                'longitude' => 79.8619,
            ],
            [
                'category_id' => 3,
                'name' => 'Sri Subramaniya Swami Kovil',
                'description' => 'A vibrant Hindu temple dedicated to Lord Murugan, known for its colorful gopuram (tower) and religious ceremonies.',
                'distance' => 15.0,
                'image' => 'kovil.jpg',
                'location' => 'Wellampitiya',
                'latitude' => 6.9300,
                'longitude' => 79.8900,
            ],
            [
                'category_id' => 5,
                'name' => 'Malwana Heritage Village',
                'description' => 'A cultural heritage site near the Kelani River showcasing traditional Sri Lankan village life, handicrafts, and local cuisine.',
                'distance' => 2.0,
                'image' => 'malwana_village.jpg',
                'location' => 'Malwana',
                'latitude' => 6.9800,
                'longitude' => 79.9900,
            ],
        ];

        foreach ($attractions as $attraction) {
            Attraction::create($attraction);
        }
    }
}

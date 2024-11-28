<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data to insert into the database
        College::create([
            'name' => 'Batangas State University',
            'address' => 'Pablo Borbon Main 1, Rizal Avenue, Batangas City, Batangas',
            'latitude' => 13.7555145360213,
            'longitude' => 121.05285796641991,
            'website' => 'https://www.batstate-u.edu.ph',
            'contact_number' => '09123456789',
            'avatar_url' => 'BatStateU-NEU-Logo-1732432775.png'
        ]);

        College::create([
            'name' => 'Batangas State University-Alangilan',
            'address' => 'Alangilan, Batangas City, Batangas',
            'latitude' => 13.784137324020477,
            'longitude' => 121.07440346876122,
            'website' => 'https://www.batstate-u.edu.ph',
            'contact_number' => '09123456788',
            'avatar_url' => 'BatStateU-NEU-Logo-1732432775.png'
        ]);

        College::create([
            'name' => 'Batangas State University-Balayan',
            'address' => 'Rizal Avenue, Balayan, Batangas',
            'latitude' => 13.938866444707742,
            'longitude' => 120.72937065292805,
            'website' => 'https://www.batstate-u.edu.ph',
            'contact_number' => '09123456787',
            'avatar_url' => 'BatStateU-NEU-Logo-1732432775.png'
        ]);

        College::create([
            'name' => 'Cavite State University',
            'address' => 'Bancod Street, Indang, Cavite',
            'latitude' => 14.201205397357777,
            'longitude' => 120.88124429961603,
            'website' => 'https://www.cvsu.edu.ph',
            'contact_number' => '09123456786',
            'avatar_url' => 'cvsu.jpg'
        ]);

        College::create([
            'name' => 'Cavite State University-Bacoor',
            'address' => 'Phase 2 Soldiers Hills IV, Molino VI, Bacoor City, Cavite',
            'latitude' => 14.413030265269981,
            'longitude' => 120.9812743934236,
            'website' => 'https://www.cvsu.edu.ph',
            'contact_number' => '09123456785',
            'avatar_url' => 'cvsu.jpg'
        ]);

        College::create([
            'name' => 'Cavite State University-Carmona',
            'address' => 'Market Drive, Carmona, Cavite',
            'latitude' => 14.318952680655524,
            'longitude' => 121.06419685673791,
            'website' => 'https://www.cvsu.edu.ph',
            'contact_number' => '09123456784',
            'avatar_url' => 'cvsu.jpg'
        ]);

        College::create([
            'name' => 'Cavite State University-Trece Martires City',
            'address' => 'Brgy. Gregorio, Trece Martires City, Cavite',
            'latitude' => 14.283339896059223,
            'longitude' => 120.87603852140474,
            'website' => 'https://www.cvsu.edu.ph',
            'contact_number' => '09123456783',
            'avatar_url' => 'cvsu.jpg'
        ]);

        College::create([
            'name' => 'Eulogio "Amang" Rodriguez Institute of Science and Technology-Cavite',
            'address' => 'Congressional Rd, Poblacion 5, General Mariano Alvarez, Cavite',
            'latitude' => 14.300090725131966,
            'longitude' => 121.0099179547789,
            'website' => 'https://www.earist.edu.ph',
            'contact_number' => '09123456782',
            'avatar_url' => 'eulogio.jpg'
        ]);

        College::create([
            'name' => 'Laguna State Polytechnic University',
            'address' => 'Bubukal, Sta. Cruz, Laguna',
            'latitude' => 14.268301855717514,
            'longitude' => 121.39797630670795,
            'website' => 'https://www.lspu.edu.ph',
            'contact_number' => '09123456781',
            'avatar_url' => 'lspu.png'
        ]);

        College::create([
            'name' => 'Polytechnic University of the Philippines-Alfonso',
            'address' => 'Brgy. Mangas 2, Alfonso, Cavite',
            'latitude' => 14.110175273655184,
            'longitude' => 120.87284520875718,
            'website' => 'https://www.pup.edu.ph',
            'contact_number' => '09123456780',
            'avatar_url' => 'OIP.jpg'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LinkType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [0, "SKOS", "http://www.w3.org/2004/02/skos/core#exactMatch", "Exact Match", 1],
            [0, "SKOS", "http://www.w3.org/2004/02/skos/core#narrowMatch", "Narrow Match", 1],
            [0, "SKOS", "http://www.w3.org/2004/02/skos/core#broadMatch", "Broad Match", 1],
            [0, "SKOS", "http://www.w3.org/2004/02/skos/core#relatedMatch", "Related Match", 1],
            [0, "SKOS", "http://www.w3.org/2004/02/skos/core#closeMatch", "Close Match", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#sameAs", "Same As", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#disjointWith", "Disjoint With", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#equivalentClass", "Equivalent Class", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#complementOf", "Complement Of", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#differentFrom", "Different From", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#equivalentProperty", "Equivalent Property", 1],
            [0, "OWL", "http://www.w3.org/2002/07/owl#inverseOf", "Inverse Of", 1],
            [0, "RDFS", "http://www.w3.org/2000/01/rdf-schema#seeAlso", "See Also", 1],
            [0, "RDFS", "http://www.w3.org/2000/01/rdf-schema#subClassOf", "Sub-class Of", 1],
            [0, "RDFS", "http://www.w3.org/2000/01/rdf-schema#subPropertyOf", "Sub Property Of", 1],
        ];

        foreach ($data as $item) {
            LinkType::create([
                'user_id' => $item[0],
                'group' => $item[1],
                'inner' => $item[2],
                'value' => $item[3],
                'public' => $item[4],
            ]);
        }

        User::create([
            'name' => 'georgekazz',
            'email' => 'george@gmail.com',
            'password' => Hash::make('giorgos123'),
        ]);
    }
}

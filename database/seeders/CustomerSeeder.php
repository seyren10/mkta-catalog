<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserArea;
use App\Models\UserCompany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                "name" => "Alex",
                "email" => "sales@theinteriorgallery.com",
                "company" => [
                    3
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Linda Hauch Fenger - Creation Group",
                "email" => "linda@creationgroup.eu",
                "company" => [
                    6
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Tarah Fred",
                "email" => "tfred@winterlandinc.com",
                "company" => [
                    1
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Rene Hansen",
                "email" => "rene@mk-illumination.dk",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Jeanne Rollins",
                "email" => "seasonaldesignsllc@gmail.com",
                "company" => [
                    20
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Nicolas Rass",
                "email" => "contact@nlcdeco.com",
                "company" => [
                    4
                ],
                "area" => [
                    3
                ],
            ],
            [
                "name" => "Jesse Gardner",
                "email" => "sales@luxurystatues.com",
                "company" => [
                    21
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Dan Casterella",
                "email" => "dcasterella@americanxmas.com",
                "company" => [
                    22
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Linda Irish",
                "email" => "sales@lmtreasures.com",
                "company" => [
                    23
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Sabina Coston",
                "email" => "sabina@christmasdesigners.com",
                "company" => [
                    24
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Brian Hamilton",
                "email" => "brian@hamactrading.com",
                "company" => [
                    5
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "John Alban",
                "email" => "jalban@envirolume.com",
                "company" => [
                    25
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Dave Gardner",
                "email" => "dave.gardner@decthemalls.com.au",
                "company" => [
                    26
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Blake Smith",
                "email" => "michelle@thedecorgroup.com",
                "company" => [
                    7
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Andrea Wells",
                "email" => "aaron@cldaz.com",
                "company" => [
                    27
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Rosali Rodriguez",
                "email" => "rosali@thechristmaspalace.com",
                "company" => [
                    28
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "John Thanos",
                "email" => "thanosjohn@yahoo.gr",
                "company" => [
                    29
                ],
                "area" => [
                    3
                ],
            ],
            [
                "name" => "Jacob Hansen",
                "email" => "jacob@mk-illumination.dk",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "John Riordan",
                "email" => "john@mk-illumination.ie",
                "company" => [
                    9,11
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "American Christmass",
                "email" => "temp@americanxmas.com",
                "company" => [
                    22
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Ed Aguilera",
                "email" => "ed@holidynamics.com",
                "company" => [
                    30
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Scott Heese",
                "email" => "scott@holidynamics.com",
                "company" => [
                    30
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Magdalena Koldys",
                "email" => "m.koldys@mkillumination.co.uk",
                "company" => [
                    9,12
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Nora Weilguny",
                "email" => "n.weilguny@mk-illumination.com",
                "company" => [
                    9,13
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Belinda Sarensen",
                "email" => "belinda@mk-illumination.dk",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Hanna Doyle",
                "email" => "h.doyle@mkillumination.co.uk",
                "company" => [
                    9,12
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Lee Rasmussen",
                "email" => "lee@mk-illumination.co.za",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Anne-Marie Davidson",
                "email" => "a.davidson@mk-illumination.ca",
                "company" => [
                    9,
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Matt Robinson",
                "email" => "matt@lonestarelectricabilene.com",
                "company" => [
                    31
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Lucy Powell",
                "email" => "lucy@lifesizemodels.com",
                "company" => [
                    32
                ],
                "area" => [
                    3
                ],
            ],
            [
                "name" => "Amy Gamble",
                "email" => "clients@holidaybrightlights.com",
                "company" => [
                    33
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Israel Guillen",
                "email" => "israel.guillen@celebrationsgroup.co.nz",
                "company" => [
                    34
                ],
                "area" => [
                    3
                ],
            ],
            [
                "name" => "Lars Neilsen",
                "email" => "lars.nielsen@mkthemedattractions.com",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Thomas Eisner",
                "email" => "t.eisner@mk-illumination.com",
                "company" => [
                    9,16
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Kim Jihong",
                "email" => "jh.kim@mk-illumination.kr",
                "company" => [
                    9,17
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Joel Faberman",
                "email" => "joel@swishcollection.com.au",
                "company" => [
                    2
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Krister Wilberg Laursen",
                "email" => "krister@universalstatues.com",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Jacinthe Guenette",
                "email" => "j.guenette@mk-illumination.ca",
                "company" => [
                    9,14
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Andrea Ko",
                "email" => "admin@markonevisual.com.au",
                "company" => [
                    35
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "N Marji",
                "email" => "nmarji@universalstatues-us.com",
                "company" => [
                    9,15
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Verad",
                "email" => "verad@universalstatues-us.com",
                "company" => [
                    8
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Linda Hauch Fenger - MK Illumination",
                "email" => "linda@mk-illumination.eu",
                "company" => [
                    9,10
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Kim Shapiro",
                "email" => "kshapiro1023@gmail.com",
                "company" => [
                    36
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Joseph Kaas",
                "email" => "info@holidaysupply.com",
                "company" => [
                    37
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Niclas Ronnberg",
                "email" => "MKSweden@MK.com.ph",
                "company" => [
                    9,18
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Oliver Billing",
                "email" => "oliver@hkow.hk",
                "company" => [
                    38
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Mark Pottinger",
                "email" => "mj@1vision.com.au",
                "company" => [
                    39
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Maven",
                "email" => "export@okled.cc",
                "company" => [
                    40
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Chris Kelly",
                "email" => "ckelly@universalstatues-us.com",
                "company" => [
                    8
                ],
                "area" => [
                    2
                ],
            ],
            [
                "name" => "Noah Kash",
                "email" => "n.kash@mk-illumination.com",
                "company" => [
                    9,19
                ],
                "area" => [
                    1
                ],
            ],
            [
                "name" => "Beccy Pottinger",
                "email" => "mali.tauro-cesca@sydneyzoo.com",
                "company" => [
                    41
                ],
                "area" => [
                    1
                ],
            ]
        ];
        foreach (collect($customers) as $client) {
            $curCustomer = User::create(
                [
                    'name' => $client['name'],
                    'email' =>
                    trim(strtolower($client['email'])),
                    'password' => Hash::make(
                        trim(strtolower($client['name']))
                    ),
                    'is_active' => 1,
                    'role_id' => 2,
                    'first_time_login' => 1,
                ]
            );

            foreach ($client['company'] as $key => $value) {
                UserCompany::create(
                    [
                        "user_id" => $curCustomer->id,
                        "company_code_id" => $value
                    ]
                );
            }
            foreach ($client['area'] as $key => $value) {
                UserArea::create(
                    [
                        "user_id" => $curCustomer->id,
                        "area_code_id" => $value
                    ]
                );
            }
        }

    }
}
class CustomerData
{

    public function __construct(public $name, public $email)
    {

    }
    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' =>
            trim(strtolower($this->email)),
            'password' => Hash::make(
                trim(strtolower($this->email))
            ),
            'is_active' => 1,
            'role_id' => 2,
            'first_time_login' => 1,
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Team;
use App\Models\Member;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $masterRole=Role::create(['name'=>'master']);
        $adminRole=Role::create(['name'=>'admin']);
        $organizerRole=Role::create(['name'=>'organizer']);

        $user=User::create([
            'name' => 'Master',
            'email' => 'master@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('master');
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $user=User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('admin');
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $user=User::create([
            'name' => 'Organizer',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('organizer');
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $user=User::create([
            'name' => 'Guardian',
            'email' => 'guardian@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $user=User::create([
            'name' => 'Member 1',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        Member::find(1)->update(['user_id'=>$user->id]);

        $user=User::create([
            'name' => 'Member 2',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        Member::find(2)->update(['user_id'=>$user->id]);

        $user=User::create([
            'name' => 'Member3',
            'email' => 'member3@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        Member::find(3)->update(['user_id'=>$user->id]);
        
    }
}

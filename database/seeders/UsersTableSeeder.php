<?php

use App\User;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath('./database/seeders/data/users.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach($records as $record) {
            User::firstOrCreate(
                [
                    'name'      => $record['name'],
                    'email'     => $record['email'],
                    'password'  => Hash::make( $record['password'] ),
                ]
            );
        }
    }
}

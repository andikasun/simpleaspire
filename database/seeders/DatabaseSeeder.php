<?php

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}


class LoansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath('./database/seeders/data/loans.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach($records as $record) {
            Loan::firstOrCreate(
                [
                    'user_id'   => $record['user_id'],
                    'amount'    => $record['amount'],
                    'loan_term' => $record['loan_term'],
                    'repayment_frequency' => $record['repayment_frequency'],
                    'status'    => $record['status']
                ]
            );
        }
    }
}

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
<?php

use App\Loan;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

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

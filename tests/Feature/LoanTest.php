<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\User;
use Tests\TestCase;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoanTest extends TestCase
{

    //mock login
    public function loginWithFakeUser(){
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        $this->be($user);
    }

    public function testRetrieveLoans() {
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        Passport::actingAs($user);
    
        $response = $this->get('/api/loan');
    
        $response->assertStatus(200);
    }
    public function testInvalidAccess() {
        //$this->loginWithFakeUser();
        $loanData = [
            "amount" => 1000,
            'loan_term' => '10',
            'repayment_frequency' => 'WEEKLY',
        ];
        $this->json('POST', 'api/loan', $loanData, ['Accept' => 'application/json'])
            ->assertStatus(401);
    }
    public function testLoanApplication()
    {
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        Passport::actingAs($user);

        $loanData = [
            "amount" => 1000,
            'loan_term' => '10',
            'repayment_frequency' => 'WEEKLY',
        ];
        $this->json('POST', 'api/loan', $loanData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "status" => "SUCCESS",
                "data" => [
                    "user_id" => 1,
                    'amount' => '1000.00',
                    'loan_term' => 10,
                    'repayment_frequency' => 'WEEKLY',
                    'status' => 'APPLIED'
                ]
            ]);
    }

    public function testApproveLoan() {
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        Passport::actingAs($user);

        $loanData = [
            "id" => 1,
            'status' => 'APPROVED'
        ];
        $this->json('POST', 'api/approveloan', $loanData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "SUCCESS",
                "data" => [
                    "user_id" => 1,
                    'amount' => 1000,
                    'loan_term' => 10,
                    'repayment_frequency' => 'WEEKLY',
                    'status' => 'APPROVED'
                ]
            ]);
    }
    public function testNegativeLoan() {
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        Passport::actingAs($user);

        $loanData = [
            "amount" => -100,
            'loan_term' => '10',
            'repayment_frequency' => 'WEEKLY',
        ];
        $this->json('POST', 'api/loan', $loanData, ['Accept' => 'application/json'])
            ->assertStatus(500)
            ->assertJson([
                "status" => "FAILED",
                "error" => [
                    "amount"=>["The amount must be at least 100."]
                ]
            ]);

    }

}
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

class AuthenticationTest extends TestCase
{


    public function testAuthentication() {
        $user = new User([
            'id' => 1,
            'name' => 'yish'
        ]);
        Passport::actingAs($user);
    
        $response = $this->get('/api/users');
    
        $response->assertStatus(200)
        ->assertJson([
            'name' => 'yish'
        ]);
    }

}
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Loan;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function before(User $user, $ability)
    {
        return false;
    }

    public function show(User $user, Loan $loan) {
        return $user->id === $loan->user_id;
    }
    public function index(User $user, Loan $loan) {
        return $user->id === $loan->user_id;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Loan;

class LoanRepayment extends Model
{
    protected $fillable = ['user_id', 'loan_id', 'amount', 'repayment_no', 'outstanding', 'status', 'payment_date'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
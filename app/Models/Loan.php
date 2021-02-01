<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LoanRepayment;
use App\Scopes\AccessScope;
use Illuminate\Support\Facades\Auth;

class Loan extends Model
{
    protected $fillable = ['user_id', 'amount', 'repayment_frequency', 'loan_term', 'status'];
    protected $with = ['loanrepayment'];
    protected static function booted()
    {
        static::addGlobalScope(new AccessScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function loanrepayment()
    {
        return $this->hasMany(LoanRepayment::class);
    }
    public function approve() {
        //create loan repayment record based on loan term
        $amount = $this->amount / $this->loan_term;
        for($i=0; $i<$this->loan_term; $i++){
            $l = new LoanRepayment();
            $l->user_id = Auth::id();
            $l->loan_id = $this->id;
            $l->amount = $amount;
            $l->repayment_no = $i+1;
            $l->outstanding = $this->amount - ($amount*($i+1));
            $l->status = "PENDING";
            $l->save();

            //$this->loanrepayment()->attach($l);
        }
        $this->status = "APPROVED";
        $this->save();
        return $this;
    }

    public function reject() {
        $this->status = "REJECTED";
        $this->save();
        return $this;
    }
}

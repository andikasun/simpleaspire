<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Loan::all());
        return response()->json(['status' => 'SUCCESS', 'data' => Loan::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'loan_term' => 'required',
            'repayment_frequency' => 'required',
        ]);
         
        if ($validator->fails()) {
            return response()->json(['status' => 'FAILED', 'error' => $validator->messages()], 500);
        }

        $loan = new Loan;
        $loan->user_id          = Auth::id();
        $loan->amount           = $request->amount;
        $loan->loan_term        = $request->loan_term;
        $loan->repayment_frequency = $request->repayment_frequency;
        $loan->status           = "APPLIED";
        $loan->save();

        return response()->json(['status' => 'SUCCESS', 'data' => $loan], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return response()->json(['status' => 'SUCCESS', 'data' => $loan], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
    public function approveloan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);
         
        if ($validator->fails()) {
            return response()->json(['status' => 'FAILED', 'error' => $validator->messages()], 500);
        }

        $loan = Loan::find($request->id);
        if( $request->status == "APPROVED") {
            $loan =  $loan->approve();
        } else if( $request->status == "REJECTED") {
            $loan = $loan->reject();
        }
        
        return response()->json(['status' => 'SUCCESS', 'data' => $loan], 200);
    }
}

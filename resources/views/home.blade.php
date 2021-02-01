@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->email != "admin@email.com")
                        {{ __('Welcome! Get started with our easy application process. ') }}
                        <br/><a class='btn btn-primary' href="/loanapplication">Apply now</a>
                    @endif
                    @if (Auth::user()->email == "admin@email.com")
                        {{ __('Welcome! Please review the applications.') }}
                        <br/><a class='btn btn-primary' href="/approveloan">Approve Loan</a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @if (Auth::user()->email != "admin@email.com")
    <div class="row justify-content-center mt-3">
        <div class="col-md-10">
            <div class="card" style='padding:20px'>
                <!-- Profile -->
                
                <table id='loan-list' class='table table-sm'>

                <tr>
                    <th>No</th>
                    <th>Amount</th>
                    <th>Loan Term</th>
                    <th>Repayment Frequency</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>


                </table>

                <!-- Profile End -->
            </div>
        </div>
    </div>
    @endif

</div>
<script>
    $.ajax({
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: 'api/loan',
        success: function (response) {
            console.log(response.data);
            res = "";
            for(var i=0;i<response.data.length;i++) {
                res = "<tr><td>" + (i+1) + "</td>";
                res += "<td>$" + response.data[i].amount.toLocaleString() + "</td>";

                res += "<td>" + response.data[i].loan_term + "</td>";
                res += "<td>" + response.data[i].repayment_frequency + "</td>";
                res += "<td>" + response.data[i].status + "</td>";


                //if(response.data[i].status == "APPROVED" || response.data[i].status == "PAID" ) {
                    res += "<td>" + "<a href='/loandetail/"+ response.data[i].id + "' class='btn btn-primary'>More details</a>" + "</td>";
                /*} else {
                    res += "<td>" + "-" + "</td>";
                }*/


                
                res += "</tr>";
                $("#loan-list").append(res);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
</script>
@endsection

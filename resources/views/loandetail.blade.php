@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><strong>{{ __('Loan Details') }}</strong></div>

                <div class="card-body">
                        <div class="row" id="loan-details">
                            {{ session('status') }}
                        </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center mt-3 loan-list">
        <div class="col-md-10">
            <div class="card" style='padding:20px'>
            <table class='table table-sm' id='loan-repayment-list'>
                <tr>
                    <th>No</th>
                    <th>Repayment #</th>
                    <th>Amount to pay</th>
                    <th>Outstanding</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Action</th>
                </tr>
            </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-10">
            <a href='/home'><strong><- Back to loan list</strong></a>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $(".btn-repay-loan").click(function() {
            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/api/payloan/' + $(this).data("repayment_id"),
                success: function (response) {
                    console.log(response);
                    location.reload();
                }
            })
        })
    })
    
    $.ajax({
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/api/loan/{{$loan_id}}',
        success: function (response) {
            console.log('LOAN DETAILS', response.data.loanrepayment);
            if ( response.data.status == "APPLIED" ){
                $(".loan-list").hide();
            }
            res = "";
            res2 = "";

            res2 += "<div class='col-md-3'><strong>Loan Term</strong></div>" +
                "<div class='col-md-3'>" + response.data.loan_term + "</div>";
            res2 += "<div class='col-md-3'><strong>Amount</strong></div>" +
                "<div class='col-md-3'>" + response.data.amount.toLocaleString() + "</div>";
            res2 += "<div class='col-md-3'><strong>Repayment Frequency</strong></div>" +
                "<div class='col-md-3'>" + response.data.repayment_frequency + "</div>";
            res2 += "<div class='col-md-3'><strong>Status</strong></div>" +
                "<div class='col-md-3'>" + response.data.status + "</div>";
            
            /*res2 += "<td>" + response.data.amount.toLocaleString() + "</td>";
            res2 += "<td>" + response.data.repayment_frequency + "</td>";
            res2 += "<td>" + response.data.status + "</td>";*/

            $("#loan-details").append(res2);


            for(var i=0;i<response.data.loanrepayment.length;i++) {
                res = "<tr><td>" + (i+1) + "</td>";
                res += "<td>" + response.data.loanrepayment[i].repayment_no + "</td>";
                res += "<td>$" + response.data.loanrepayment[i].amount.toLocaleString() + "</td>";
                res += "<td>$" + response.data.loanrepayment[i].outstanding.toLocaleString() + "</td>";
                res += "<td>" + response.data.loanrepayment[i].status + "</td>";
                if(response.data.loanrepayment[i].status == "PAID") {
                    res += "<td>" + response.data.loanrepayment[i].payment_date + "</td>";
                    res += "<td>" + "<strong><button disabled class='btn btn-secondary  '>PAID</button></strong>" + "</td>";
                } else {
                    res += "<td>-</td>";
                    res += "<td>" + "<a data-repayment_id='" + response.data.loanrepayment[i].id + "' href='#"+ response.data.loanrepayment[i].id + "' class='btn btn-success btn-repay-loan'>Pay</a>" + "</td>";

                }
                res += "</tr>";
                $("#loan-repayment-list").append(res);
            }

        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
</script>
@endsection

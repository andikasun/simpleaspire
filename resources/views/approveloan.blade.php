@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center mt-3 loan-list">
        <div class="col-md-10">
            <div class="card" style='padding:20px'>
            <h1 class='mb-3'>Loan Application List</h1>
            <table class='table table-sm' id='loan-list'>
                <tr>
                    <th>No</th>
                    <th>Amount</th>
                    <th>Loan Term (Weekly)</th>
                    <th>Repayment Frequency</th>
                    <th>Status</th>
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
        $(".btn-admin-action").click(function() {
            loan_id = $(this).data("loan_id");
            action_result = $(this).data("action_res");
            console.log(loan_id, action_result);
            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/api/approveloan',
                data: {id:loan_id, status: action_result},
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
        url: '/api/loan/',
        success: function (response) {
            console.log(response);
            for(var i=0;i<response.data.length;i++) {
                res = "";
                res = "<tr><td>" + (i+1) + "</td>";
                res += "<td>$" + response.data[i].amount.toLocaleString() + "</td>";

                res += "<td>" + response.data[i].loan_term + "</td>";
                res += "<td>" + response.data[i].repayment_frequency + "</td>";
                res += "<td>" + response.data[i].status + "</td>";


                if(response.data[i].status == "APPLIED") {
                    res += "<td>" + "<a data-action_res='APPROVED' data-loan_id='" + response.data[i].id + "'" + " href='#' class='btn btn-primary btn-admin-action'>Approve</a>&nbsp;" + 
                    "<a data-action_res='REJECTED' data-loan_id='" + response.data[i].id + "'" + " href='#' class='btn btn-primary btn-admin-action'>Reject</a>" + "</td>";
                } else {
                    res += "<td>" + "-" + "</td>";
                }


                
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

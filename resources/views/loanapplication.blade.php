@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Loan Application') }}</div>

                <div class="card-body">
                    <h1>Apply for loan</h1>
                    <form id='application-form'>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Amount</label>
                            <div class="col-sm-10">
                            <input type="number" max="10000" class="form-control" name="amount" required="required" placeholder="Input amount in dollar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Loan Term</label>
                            <div class="col-sm-10">
                            <select id="inputState" class="form-control" name="loan_term">
                                <?php
                                    for($i = 1; $i< 25;$i++) {
                                        echo sprintf("<option value='%s'>%s</option>", $i, $i);
                                    }
                                ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Repayment Frequency</label>
                            <div class="col-sm-10">
                            <input type="text" disabled="disabled" class="form-control" name="repayment_frequency" value="WEEKLY">
                            </div>
                        </div>


                        <input type="hidden" name="repayment_frequency" value="WEEKLY">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
$(document).ready(function() {


$('#application-form').submit(function(event) {
    event.preventDefault();
    $.ajax({
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'api/loan',
        data: $('#application-form').serialize(),
        success: function (response) {
            console.log(response.data);
            window.location.replace("/home");
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});
});
</script>
@endsection

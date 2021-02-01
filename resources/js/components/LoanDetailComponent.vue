<template>
    <table class="table" id="example-1">
        <tr>
            <th>No</th>
            <th>Amount</th>
            <th>Loan Term</th>
            <th>Repayment Frequency</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <tr v-for="item in loans" :key="item.id">
            <td>{{ item.user_id }} </td>
            <td>{{ item.loan_term }}</td>
            <td>${{ item.amount.toLocaleString() }}</td>
            <td>{{ item.repayment_frequency }}</td>
            <td>{{ item.status }}</td>
            <td><a href='' class="btn btn-primary" v-if="item.status='APPLIED'">See details</a></td>
            
        </tr>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                loan: ''
            }
        },
        mounted() {
            axios.get('/api/loan/')
                .then(response => {
                console.log(response.data.data);
                this.loan = response.data.data;
            });
        },
        props: {
            apiData: {
                type: String,
                required: true
            }
        }

    }
</script>
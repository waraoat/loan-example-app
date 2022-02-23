<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" style="padding-bottom: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h3>Loan</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">  
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                        <th scope="row">ID:</th>
                        <td>{{loan.id}}</td>
                        </tr>
                        <tr>
                        <th scope="row">Loan Amount:</th>
                        <td>{{parseFloat(loan.loan_amount).toFixed(2)}} ฿</td>
                        </tr>
                        <tr>
                        <th scope="row">Loan Term:</th>
                        <td>{{loan.loan_term}} Years</td>
                        </tr>
                        <tr>
                        <th scope="row">Interest Rate:</th>
                        <td>{{parseFloat(loan.interest_rate).toFixed(2)}} %</td>
                        </tr>
                        <tr>
                        <th scope="row">Created at:</th>
                        <td>{{loan.created_at | formatDateTime}}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h3>Repayment Schedules</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">  
                    <table class="table" id="myTable">
                        <thead class="thead-dark">
                            <tr align="center">
                            <th scope="col">Payment No</th>
                            <th scope="col">Date</th>
                            <th scope="col">Payment Amount</th>
                            <th scope="col">Principal</th>
                            <th scope="col">Interest</th>
                            <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align="center" v-for="(repayment_schedule, index) in loan.repayment_schedules" :key="repayment_schedule.id">
                            <td>{{repayment_schedule.payment_no}}</td>
                            <td>{{repayment_schedule.date | formatDate}}</td>
                            <td>{{parseFloat(repayment_schedule.payment_amount).toFixed(2)}}</td>
                            <td>{{parseFloat(repayment_schedule.principal).toFixed(2)}}</td>
                            <td>{{parseFloat(repayment_schedule.interest).toFixed(2)}}</td>
                            <td>{{parseFloat(repayment_schedule.balance).toFixed(2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <a class="btn btn-primary" href="/"><< Back</a>
</div>
</template>
<script>
export default {
    props: ['loan_id'],
    data() {
        return {
            loan: []
        }
    },
    methods: {
        getLoan() {
            axios.get(`/api/loans/${this.loan_id}`).then((response) => {
                this.loan = response.data;
            }).catch((error) => {
                console.log(error);
            })
        }
    },
    created() {
        this.getLoan()
    }
}
</script>
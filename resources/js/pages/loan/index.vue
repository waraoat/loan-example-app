<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2>All Loans</h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">  
                    <div class="card-body" style="padding-left: 0rem;">
                        <a href="/loans/create">
                            <button type="button" class="btn btn-primary">Add New Loan</button>
                        </a>      
                    </div>
                    <table class="table" id="myTable">
                        <thead class="thead-dark">
                            <tr align="center">
                            <th scope="col">ID</th>
                            <th scope="col">Loan Amount</th>
                            <th scope="col">Loan Term</th>
                            <th scope="col">Interest Rate</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align="center" v-for="(loan, index) in loans" :key="loan.id">
                            <th scope="row">{{ index+1 }}</th>
                            <td>{{loan.loan_amount}}</td>
                            <td>{{loan.loan_term}} Years</td>
                            <td>{{loan.interest_rate}} %</td>
                            <td>{{loan.started_at}}</td>
                            <td>
                                <a v-bind:href="'loans/'+loan.id">
                                    <input type="button" class="btn btn-primary" value='View'>
                                </a>
                                <a v-bind:href="'loans/'+loan.id+'/edit'">
                                    <input type="button" class="btn btn-success" value='Edit'>
                                </a>
                                <button class="btn btn-danger" @click="deleteLoan(loan.id)">Delete</button>
                            </td>
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
        data() {
            return {
                loans: [],
            }
        },
        methods: {
            getLoans() {
                axios.get('/api/loans').then((response) => {
                    this.loans = response.data;
                }).catch((error) => {
                    console.log(error);
                })
            },
            deleteLoan(id) {
                axios.delete(`/api/loans/${id}`).then((response) => {
                    let i = this.loans.map(data => data.id).indexOf(id);
                    this.loans.splice(i, 1)
                })
            }
        },
        mounted() {
            this.getLoans()
        }
    }
</script>
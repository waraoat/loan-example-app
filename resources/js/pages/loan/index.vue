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
                    <div class="card-body" style="padding-left: 0rem; padding-right: 0rem; text-align:left;">
                        <a href="/loans/create">
                            <button type="button" class="btn btn-primary">Add New Loan</button>
                        </a>
                        <span style="float:right;">
                            <button type="button" class="btn btn-secondary" v-on:click="is_search = !is_search">Advanced Search</button>
                        </span>        
                    </div>

                    <search-loan @clicked="filterLoan" v-if="is_search" :loans=this.loans></search-loan>
                    
                    <loan-list-table :loans=this.filtered_loans></loan-list-table>
                    
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
                filtered_loans: [],
                loans: [],
                is_search: false,
            }
        },
        methods: {
            getLoans() {
                axios.get('/api/loans').then((response) => {
                    this.loans = response.data;
                    this.filtered_loans = response.data;
                }).catch((error) => {
                    console.log(error);
                })
            },
            filterLoan(data) {
                this.filtered_loans = data;
            },
        },
        mounted() {
            this.getLoans()
        }
    }
</script>
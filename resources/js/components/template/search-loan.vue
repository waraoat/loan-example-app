<template>
    <div class="card">
        <div class="card-header">
            Advanced Search
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Loan Amount (THB)</label>
                <div class="input-group" style="width: 30rem;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Min</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.min_loan_amount">
                    <div class="input-group-prepend" style="padding-left: 1rem;">
                        <span class="input-group-text" id="">Max</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.max_loan_amount">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Loan Term (Years)</label>
                <div class="input-group" style="width: 30rem;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Min</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.min_loan_term">
                    <div class="input-group-prepend" style="padding-left: 1rem;">
                        <span class="input-group-text" id="">Max</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.max_loan_term">
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label">Interest Rate (%)</label>
                <div class="input-group" style="width: 30rem;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Min</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.min_interest_rate">
                    <div class="input-group-prepend" style="padding-left: 1rem;">
                        <span class="input-group-text" id="">Max</span>
                    </div>
                    <input type="number" class="form-control" v-model="filter.max_interest_rate">
                </div>
            </div>

            <div class="card-body" style="padding: 1rem 1rem 0rem 0rem;">
                <button type="button" class="btn btn-secondary" v-on:click="onClick">Search</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['loans'],
        data() {
            return {
                filter: {
                    min_loan_amount: 1000,
                    max_loan_amount: 100000000,
                    min_loan_term: 1,
                    max_loan_term: 50,
                    min_interest_rate: 1,
                    max_interest_rate: 36,
                },
            }
        },
        methods: {
            onClick() {
                let filtered_loans = this.loans.filter(loan => {
                    let amount_in_range = (+loan.loan_amount >= +this.filter.min_loan_amount) && (+loan.loan_amount <= +this.filter.max_loan_amount);
                    let term_in_range = (+loan.loan_term >= +this.filter.min_loan_term) && (+loan.loan_term <= +this.filter.max_loan_amount);
                    let interest_rate_in_range = (+loan.interest_rate >= +this.filter.min_interest_rate) && (+loan.interest_rate <= +this.filter.max_interest_rate)

                    return amount_in_range && term_in_range && interest_rate_in_range;
                })

                this.$emit('clicked', filtered_loans)
            }
        }
    }
</script>
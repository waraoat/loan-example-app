<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label>Loan Amount</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="loan_amount" placeholder="Number" name="loan_amount" v-model="data.loan_amount" value="100000" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">฿</span>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errors && errors.loan_amount">
                    {{ errors.loan_amount[0] }}
                </div>
            </div>

            <div class="form-group">
                <label>Loan Term</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="loan_term" placeholder="Number" name="loan_term" v-model="data.loan_term" value="1" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">Years</span>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errors && errors.loan_term">
                    {{ errors.loan_term[0] }}
                </div>
            </div>

            <div class="form-group">
                <label>Intereset Rate</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="interest_rate" placeholder="Number" name="interest_rate" v-model="data.interest_rate" value="10" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errors && errors.interest_rate">
                    {{ errors.interest_rate[0] }}
                </div>
            </div>

            <div class="form-group">
                <label>Start Date</label>
                <div class="input-group mb-3" style="display:flex;">
                    <select class="form-select" id="month" name="month" v-model="data.month">
                        <option value="1" selected>Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Aug</option>
                        <option value="9">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                    <select class="form-select" id="year" name="year" v-model="data.year">
                        <option value="2022" selected>2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                    </select>
            </div>
            <div class="alert alert-danger" v-if="errors && (errors.month)">
                {{ errors.month[0] }}
            </div>
            <div class="alert alert-danger" v-if="errors && (errors.year)">
                {{ errors.year[0] }}
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href=""><input type="button" class="btn btn-danger" value="Cancel"></a>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['errors', 'loan'],

        data() {
            return {
                data: {
                    loan_amount: 10000,
                    loan_term: 1,
                    interest_rate: 10,
                    month: 1,
                    year: 2022
                },

            }
        },
        methods: {
            onSubmit() {
                this.$emit('submitted', this.data)
            }
        }
    }
</script>
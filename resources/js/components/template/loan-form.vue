<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label>Loan Amount</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="loan_amount" placeholder="Number" name="loan_amount" v-model="data.loan_amount" required>
                    <div class="input-group-append">
                        <span class="input-group-text">฿</span>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errors && errors.loan_amount">
                    {{ errors.loan_amount[0] }}
                </div>
            </div>

            <div class="form-group">
                <label>Loan Term</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="loan_term" placeholder="Number" name="loan_term" v-model="data.loan_term" required>
                    <div class="input-group-append">
                        <span class="input-group-text">Years</span>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errors && errors.loan_term">
                    {{ errors.loan_term[0] }}
                </div>
            </div>

            <div class="form-group">
                <label>Intereset Rate</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="interest_rate" placeholder="Number" name="interest_rate" v-model="data.interest_rate" required>
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
        <button type="submit" class="btn btn-primary">{{ submit_button_name }}</button>
        <a href=""><input type="button" class="btn btn-danger" value="Cancel"></a>
        </form>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            errors: Object, 
            loan: {
                type: Object,
                default(rawProps) {
                    return { 
                        loan_amount: null, 
                        loan_term: null,
                        interest_rate: null,
                        started_at: '2022-01-01T00:00:00.000000Z',
                    }
                }
            }, 
            submit_button_name: String,
        },
        data() {
            return {
                data: {
                    loan_amount: parseFloat(this.loan.loan_amount).toFixed(2),
                    loan_term: this.loan.loan_term,
                    interest_rate: parseFloat(this.loan.interest_rate).toFixed(2),
                    month: moment(this.loan.started_at).format('M'),
                    year: moment(this.loan.started_at).format('YYYY'),
                }
            }
        },
        methods: {
            onSubmit() {
                this.$emit('submitted', this.data)
            }
        }
    }
</script>
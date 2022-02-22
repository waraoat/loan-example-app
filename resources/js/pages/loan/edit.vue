<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit</div>

                <div class="card-body">
                    <div class="container">

                    <div class="row">
                      <div class="col-md-12">
                        <h3>Edit Loan</h3>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="row">
                        </div>
                            <loan-form @submitted="editLoan" v-if="this.loan.id" submit_button_name="Edit" :errors=this.errors :loan=this.loan></loan-form>
                        </div>
                    </div>
                </div>
   
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <a class="btn btn-primary" href="/"><< Back</a>
      </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['loan_id'],
    data() {
        return {
            errors: {},
            loan: {},
        }
    },
    methods: {
        getLoan() {
            axios.get(`/api/loans/${this.loan_id}`).then((response) => {
                this.loan = response.data;
            }).catch((error) => {
                console.log(error);
            })
        },
        editLoan(data) {
            axios.patch(`/api/loans/${this.loan_id}`, data).then(response => {
                Swal.fire(
                    'Updated!',
                    'Loan has been updated.',
                    'success'
                ).then(function() {
                    window.location.href = `/loans/${response.data.id}`;
                })
            }).catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    },
    mounted() {
        this.getLoan()
    }
}
</script>
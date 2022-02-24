<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Create</div>

                <div class="card-body">
                    <div class="container">

                    <div class="row">
                      <div class="col-md-12">
                        <h3>Create Loan</h3>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="row">
                        </div>
                            <loan-form @submitted="createLoan" submit_button_name="Create" :errors=this.errors></loan-form>
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
    data() {
        return {
            errors: {},
        }
    },
    methods: {
        createLoan(data) {
            axios.post('/api/loans', data).then(response => {
                Swal.fire(
                    'Created!',
                    'Loan has been created.',
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
    }
}
</script>
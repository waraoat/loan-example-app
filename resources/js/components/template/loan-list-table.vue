<template>
<table class="table">
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
        <td>{{parseFloat(loan.loan_amount).toFixed(2)}}</td>
        <td>{{loan.loan_term}} Years</td>
        <td>{{parseFloat(loan.interest_rate).toFixed(2)}} %</td>
        <td>{{loan.created_at | formatDateTime}}</td>
        <td style="white-space: nowrap; width: 0%;">
            <a v-bind:href="`loans/${loan.id}`">
                <input type="button" class="btn btn-primary" value='View'>
            </a>
            <a v-bind:href="`loans/${loan.id}/edit`">
                <input type="button" class="btn btn-success" value='Edit'>
            </a>
            <button class="btn btn-danger" v-on:click="deleteLoan(loan.id)">Delete</button>
        </td>
        </tr>
    </tbody>
</table>
</template>
<script>
export default {
    props: ['loans'],
    methods: {
        deleteLoan(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/loans/${id}`).then((response) => {
                        let i = this.loans.map(data => data.id).indexOf(id);
                        this.loans.splice(i, 1)
                        
                        Swal.fire(
                            'Deleted!',
                            'Loan has been deleted.',
                            'success'
                        )
                    })
                }
            })
        },
    }
}
</script>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" style="padding-bottom: 1.5rem;">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            
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
                        <td>{{$loan->id}}</td>
                        </tr>
                        <tr>
                        <th scope="row">Loan Amount:</th>
                        <td>{{$loan->loan_amount}} ฿</td>
                        </tr>
                        <tr>
                        <th scope="row">Loan Term:</th>
                        <td>{{$loan->loan_term}} Years</td>
                        </tr>
                        <tr>
                        <th scope="row">Interest Rate:</th>
                        <td>{{$loan->interest_rate}} %</td>
                        </tr>
                        <tr>
                        <th scope="row">Created at:</th>
                        <td>{{$loan->created_at}}</td>
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
                            <th scope="col">#</th>
                            <th scope="col">Payment No</th>
                            <th scope="col">Date</th>
                            <th scope="col">Payment Amount</th>
                            <th scope="col">Principal</th>
                            <th scope="col">Interest</th>
                            <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan->repayment_schedules as $index => $repayment_schedule)
                            <tr align="center">
                            <th scope="row">{{ ++$index }}</th>
                            <td>{{$repayment_schedule->payment_no}}</td>
                            <td>{{$repayment_schedule->date}}</td>
                            <td>{{$repayment_schedule->payment_amount}} %</td>
                            <td>{{$repayment_schedule->principal}}</td>
                            <td>{{$repayment_schedule->balance}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <a class="btn btn-primary" href="{{route('loan.index')}}"><< Back</a>
</div>

@endsection
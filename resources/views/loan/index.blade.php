@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
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
                        <a href="{{route('loans.create')}}">
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
                            @foreach ($loans as $index=>$loan)
                            <tr align="center">
                            <th scope="row">{{ ++$index }}</th>
                            <td>{{$loan->loan_amount}}</td>
                            <td>{{$loan->loan_term}} Years</td>
                            <td>{{$loan->interest_rate}} %</td>
                            <td>{{$loan->started_at}}</td>
                            <td>
                                <a href="{{route('loans.show',$loan->id)}}">
                                    <input type="button" class="btn btn-primary" value='View'>
                                </a>
                                <a href="{{route('loans.edit',$loan->id)}}">
                                    <input type="button" class="btn btn-success" value='Edit'>
                                </a>
                                <form action="{{route('loans.destroy', $loan->id)}}" method="post" style="display: inline">
                                <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you srure to delete loan id: {{$loan->id}}?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <a class="btn btn-primary" href="{{route('home')}}"><< Back</a>
</div>

@endsection
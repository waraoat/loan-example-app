@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit</div>

                <div class="card-body">
                    <div class="container">

                    <div class="row">
                      <div class="col-md-12">
                        <h3>Edit Loan : {{ $loan->id }}</h3>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="row">
                        </div>
                          <form action="{{route('put.loan', $loan->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label>Loan Amount</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="loan_amount" placeholder="Number" name="loan_amount" value="{{ $loan->loan_amount }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">฿</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Loan Term</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="loan_term" placeholder="Number" name="loan_term" value="{{ $loan->loan_term }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Years</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Intereset Rate</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="interest_rate" placeholder="Number" name="interest_rate" value="{{ $loan->interest_rate }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group mb-3" style="display:flex;">
                                    <select class="custom-select" id="month" name="month">
                                        <option value="1">Jan</option>
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
                                    <select class="custom-select" id="year" name="year">
                                        <option value="2022">2022</option>
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
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{route('get.loan.index')}}"><input type="button" class="btn btn-danger" value="Cancel"></a>
                          </form>
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
        <a class="btn btn-primary" href="{{route('get.loan.index')}}"><< Back</a>
      </div>
    </div>
</div>
@endsection

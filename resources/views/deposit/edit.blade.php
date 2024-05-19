@extends('layout')

@section('content')
<div class="container">
    <form action="{{URL::to('deposit/'.$deposit->id)}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Amount</label>
        <input type="number" class="form-control" name="amount" value="{{ $deposit->amount }}" >
        </div>
        <button type="submit" class="btn btn-primary">Update Deposit</button>
    </form>
</div>   
@endsection
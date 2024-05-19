@extends('layout')

@section('content')
<div class="container">
    <form action="{{ route('deposit.store') }}" method="post">
        @csrf
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Amount</label>
        <input type="number" class="form-control" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Deposit</button>
    </form>
</div>   
@endsection
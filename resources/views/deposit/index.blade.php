@extends('layout')

@section('content')
<div class="container">
<table class="table">
    <thead>
        <a class="btn btn-primary" href="{{ route('deposit.create') }}"> Add Deposit</a>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Amount</th>
        <th scope="col">Type</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    @php
        $i= 1;
    @endphp
    <tbody>
        @forelse ($deposits as $deposit)
        <tr>
            <th scope="row">{{ $i++ }}</th>
            <td>{{ $deposit->amount }} TK</td>
            <td>{{ $deposit->transaction_type }} </td>
            <td>
                <a class="btn btn-sm btn-success" href="{{URL::to('deposit/'.$deposit->id.'/edit')}}"> Edit</a>
            </td>
        </tr>
        @empty
            No Deposit Yet
        @endforelse

    </tbody>
  </table>
</div>   
@endsection
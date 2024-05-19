@extends('layout')

@section('content')
<div class="container">
<table class="table">
    <thead>
        <a class="btn btn-primary" href="{{ route('withdrawal.create') }}"> Add Withdraw</a>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Amount</th>
        <th scope="col">Type</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    @php
        $i= 1;
    @endphp
    <tbody>
        @forelse ($withdraws as $withdraw)
        <tr>
            <th scope="row">{{ $i++ }}</th>
            <td>{{ $withdraw->amount }} TK</td>
            <td>{{ $withdraw->transaction_type }} </td>
            <td>{{ $withdraw->date }} </td>
            <td>
                <a class="btn btn-sm btn-success" href="{{URL::to('withdrawal/'.$withdraw->id.'/edit')}}"> Edit</a>
            </td>
        </tr>
        @empty
            No withdraw Yet
        @endforelse

    </tbody>
  </table>
</div>   
@endsection
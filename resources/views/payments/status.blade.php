@extends('layout')

@section('content')
  <main class="payments pt-5 pb-5">
    <div class="container">
      <h2>Payment status</h2>
      
      @if ($response['status']['status'] !== 'NO_COOKIE')
        @include('payments.details', $response)

        @if ($response['status']['status'] !== 'APPROVED')
          @include('payments.button', ['order' => $order])
        @endif
      @else
        <div class="alert alert-warning mt-4">
          <p class="m-0">You don't have a payment in process, please check the list of orders.</p>
        </div>
      @endif
    </div>
  </main>
@endsection

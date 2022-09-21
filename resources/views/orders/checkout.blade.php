@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>Checkout</h2>

      @if ($order)
        @include('orders.details',[
          'order_id' => $order_id,
          'order' => $order
        ])

        @include('payments.button', ['order' => $order])
      @else
          <div class="alert alert-danger mt-4">
            <p class="m-0">
              The order could not be created or viewed, please try again.
            </p>
          </div>
      @endif
    </div>
  </main>
@endsection
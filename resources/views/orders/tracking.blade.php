@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>Tracking order</h2>

      <form action="/orders/tracking" method="POST" class="form-horizontal mt-4">
        @csrf

        <input type="number" min="0" name="order_id" placeholder="Enter your order ID" class="form-control mb-4" required>

        <button class="btn btn-dark">Track order</button>
      </form>

      @if (Request::isMethod('post'))
        @if ($order)
            Order
        @else
            <div class="alert alert-warning mt-5">
              <p class="m-0">
                We didn't find an order with ID <strong>{{ $order_id }}</strong>. Please check your order ID and try again.
              </p>
            </div>
        @endif
      @endif

    </div>
  </main>
@endsection
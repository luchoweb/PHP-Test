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

        <form action="/orders/pay" class="mt-4 text-center" method="POST">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order_id }}">
          <input type="hidden" name="customer_document" value="{{ $order['customer_document'] }}">
          <input type="hidden" name="customer_documentType" value="{{ $order['customer_documentType'] }}">
          <input type="hidden" name="customer_name" value="{{ $order['customer_name'] }}">
          <input type="hidden" name="customer_surname" value="{{ $order['customer_surname'] }}">
          <input type="hidden" name="customer_email" value="{{ $order['customer_email'] }}">
          <input type="hidden" name="customer_mobile" value="{{ $order['customer_mobile'] }}">
          <input type="hidden" name="order_total" value="{{ $order['total'] }}">
          <button class="btn btn-dark btn-lg">
            Pay now
          </button>

          <p class="m-0 mt-3">
            <small>Secure by PlaceToPay</small>
          </p>
        </form>
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
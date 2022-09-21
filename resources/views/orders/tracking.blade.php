@extends('layout')

@section('content')
  <main class="orders pb-5">
    <section class="search pt-5 pb-5 bg-light">
      <div class="container">
        <h2>Tracking order</h2>

        <form action="/orders/tracking" method="POST" class="form-horizontal mt-4">
          @csrf

          <div class="form-group row align-items-center">
            <div class="col-12 col-md-9 col-lg-4 mb-3 mb-md-0">
              <input type="number" min="0" name="order_id" placeholder="Enter your order ID" class="form-control" required>
            </div>

            <div class="col-12 col-md-3 col-lg-2 text-center text-md-start">
              <button class="btn btn-dark p-2">Track order</button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <div class="container">
      @if (Request::isMethod('post'))
        @if ($order)
          @include('orders.details',[
            'order_id' => $order['id'],
            'order' => $order
          ])

          @if ($order['payment_status'] !== 'APPROVED')
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
          @endif
        @else
            <div class="alert alert-warning mt-5">
              <h5>No order found</h5>
              <p class="m-0">
                We didn't find an order with ID <strong>{{ $order_id }}</strong>. Please check your order ID and try again.
              </p>
            </div>
        @endif
      @endif

    </div>
  </main>
@endsection
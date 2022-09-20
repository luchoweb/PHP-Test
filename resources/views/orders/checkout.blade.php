@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>Checkout</h2>

      <div class="order-details mt-4">
        <h3 class="title pt-3 pb-3 text-center m-0 bg-dark text-light">
          Order details
          <span class="d-block mt-2">Created at {{ date('d-M-Y h:s A', strtotime($order['created_at'])) }}</span>
        </h3>

        <ul class="details list-unstyled m-0 p-0">
          <li class="p-3">
            <p class="m-0">
              <strong>ID de seguimiento</strong>: {{ $order_id }}
            </p>
          </li>

          <li class="p-3">
            <p class="m-0">
              <strong>Customer name</strong>: {{ $order['customer_name'] }}
            </p>
          </li>

          <li class="p-3">
            <p class="m-0">
              <strong>Customer email</strong>: {{ $order['customer_email'] }}
            </p>
          </li>

          <li class="p-3">
            <p class="m-0">
              <strong>Customer mobile</strong>: {{ $order['customer_mobile'] }}
            </p>
          </li>

          <li class="p-3">
            <p class="m-0">
              <strong>Product</strong>: {{ $product['product_name'] }}
            </p>
          </li>

          <li class="p-3">
            <p class="m-0">
              <strong>Total</strong>: {{ formatCurrency($product['product_price'], 'COP') }}
            </p>
          </li>
        </ul>
      </div>

      <form action="" class="mt-4 text-center">
        <button class="btn btn-dark btn-lg">
          Pay now
        </button>
      </form>
    </div>
  </main>
@endsection
@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2 class="mb-4">All orders</h2>

      <div class="table-responsive">
        <table class="table">
          <thead class="bg-dark text-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Customer name</th>
              <th scope="col">Product</th>
              <th scope="col">Total</th>
              <th scope="col">Status</th>
              <th scope="col">Payment</th>
              <th scope="col" class="text-center">Details</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
            <tr>
              <th scope="row">{{ $order->id }}</th>
              <td>{{ $order->customer_name .' '. $order->customer_surname }}</td>
              <td>{{ $order->product->product_name }}</td>
              <td>{{ formatCurrency($order->total, 'COP') }}</td>
              <td>{{ $order->status }}</td>
              <td>{{ $order->payment_status }}</td>
              <td class="text-center">
                <form action="/orders/tracking" method="POST">
                  @csrf
                  <input type="hidden" name="order_id" value="{{ $order->id }}">
                  <button class="btn btn-dark btn-sm">&rdsh;</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </main>
@endsection
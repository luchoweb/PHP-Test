@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>New order</h2>

      <form action="/orders/checkout" class="form" method="POST">
        @csrf
        <input type="text" placeholder="Full name" name="customer_name">
        <input type="email" placeholder="Full name" name="customer_email">
        <input type="number" placeholder="Full name" name="customer_mobile">
      
        <button>Go to checkout</button>
      </form>
    </div>
  </main>
@endsection
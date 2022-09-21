@extends('layout')

@section('content')
  <main class="payments pt-5 pb-5">
    <div class="container">
      <h2>Payment</h2>

      <div class="alert alert-danger mt-4">
        <h5>ERROR</h5>
        <p class="m-0">An error has occurred while processing your order. Please, try again.</p>
        <p class="mt-2 mb-0">
          <strong>Details:</strong> {{ $response['message'] }}
        </p>
      </div>
    </div>
  </main>
@endsection

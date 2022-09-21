@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>Payment</h2>

      @if ($response['status'] === 'FAILED')
        <div class="alert alert-danger mt-4">
          <h5>ERROR</h5>
          <p class="m-0">{{ $response['message'] }}</p>
        </div>
      @endif
    </div>
  </main>
@endsection

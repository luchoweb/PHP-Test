<div class="payment-details mt-4">
  <h3 class="title pt-3 pb-3 text-center m-0 bg-dark text-light">
    Payment #{{$response['requestId']}}
  </h3>

  <ul class="details list-unstyled m-0 p-0">
    <li class="p-3">
      <p class="m-0">
        <strong>Order ID</strong>: {{ $response['request']['payment']['reference'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Payment status</strong>: <strong>{{ $response['status']['status'] }}</strong>: <small>{{ $response['status']['message'] }}</small>
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Customer name</strong>: {{ $response['request']['payer']['name'] }} {{ $response['request']['payer']['surname'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Customer email</strong>: {{ $response['request']['payer']['email'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Total</strong>: {{ formatCurrency($response['request']['payment']['amount']['total'], 'COP') }}
      </p>
    </li>
  </ul>
</div>

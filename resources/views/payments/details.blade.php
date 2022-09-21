<div class="payment-details mt-4">
  <h3 class="title pt-3 pb-3 text-center m-0 bg-dark text-light">
    Payment #{{$response['requestId']}}
    <span class="d-block">
      Order created at {{ date('d-m-Y h:i A', strtotime($order['created_at'])) }}
    </span>
  </h3>

  <ul class="details list-unstyled m-0 p-0">
    <li class="p-3">
      <p class="m-0">
        <strong>Order ID</strong>: {{ $order['id'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        @if ($response['payment'] === NULL )
          <strong>Payment status</strong>: <strong>{{ $response['status']['status'] }}</strong>: <small>{{ $response['status']['message'] }}</small>
        @else
          <strong>Payment status</strong>: <strong>{{ $response['payment'][0]['status']['status'] }}</strong>: <small>{{ $response['payment'][0]['status']['message'] }}</small>
        @endif
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Customer name</strong>: {{ $order['customer_name']  }} {{ $order['customer_surname'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Customer email</strong>: {{ $order['customer_email'] }}
      </p>
    </li>

    <li class="p-3">
      <p class="m-0">
        <strong>Total</strong>: {{ formatCurrency($order['total'], 'COP') }}
      </p>
    </li>

    @if ($response['payment'] !== NULL)
      <li class="p-3">
        <p class="m-0">
          <strong>Payment method</strong>: {{ $response['payment'][0]['paymentMethodName'] }}
        </p>
      </li>
    @endif

    <li class="p-3">
      <p class="m-0">
        <strong>IP</strong>: {{ $response['request']['ipAddress'] }}
      </p>
    </li>
  </ul>
</div>

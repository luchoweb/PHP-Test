<form action="/orders/pay" class="mt-4 text-center" method="POST">
  @csrf
  <input type="hidden" name="order_id" value="{{ $order['id'] }}">
  <input type="hidden" name="customer_document" value="{{ $order['customer_document'] }}">
  <input type="hidden" name="customer_documentType" value="{{ $order['customer_documentType'] }}">
  <input type="hidden" name="customer_name" value="{{ $order['customer_name'] }}">
  <input type="hidden" name="customer_surname" value="{{ $order['customer_surname'] }}">
  <input type="hidden" name="customer_email" value="{{ $order['customer_email'] }}">
  <input type="hidden" name="customer_mobile" value="{{ $order['customer_mobile'] }}">
  <input type="hidden" name="order_total" value="{{ $order['total'] }}">
  <button class="btn btn-dark btn-lg">
    @if ($order['payment_status'] === 'REJECTED')
      Retry payment
    @else
      Pay now  
    @endif
  </button>

  <p class="m-0 mt-3">
    <small>Secure by PlaceToPay</small>
  </p>
</form>
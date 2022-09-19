<form action="/orders/checkout" class="form" method="POST">
  @csrf
  <input type="text" placeholder="Full name" name="customer_name">

  <button>Go to checkout</button>
</form>
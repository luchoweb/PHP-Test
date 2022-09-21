@extends('layout')

@section('content')
  <main class="orders pt-5 pb-5">
    <div class="container">
      <h2>New order</h2>

      <form action="/orders/checkout" class="form-horizontal mt-4" method="POST">
        @csrf

        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-12 col-md-6 mb-4">
            <label for="document_type">Document Type</label>
            <select name="customer_documentType" id="document_type" class="form-select" required>
              <option value="CC" selected>CC</option>
            </select>
          </div>

          <div class="col-12 col-md-6 mb-4">
            <label for="document">Document</label>
            <input type="text" pattern="[1-9]{1,}" id="document" placeholder="Document" name="customer_document" class="form-control" required>
          </div>
          
          <div class="col-12 col-md-6 mb-4">
            <label for="name">Name</label>
            <input type="text" id="name" placeholder="Name" name="customer_name" class="form-control" required>
          </div>

          <div class="col-12 col-md-6 mb-4">
            <label for="surname">Surname</label>
            <input type="text" id="surname" placeholder="Name" name="customer_surname" class="form-control" required>
          </div>
  
          <div class="col-12 col-md-6 mb-4">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Email" name="customer_email" class="form-control" required>
          </div>
  
          <div class="col-12 col-md-6 mb-4">
            <label for="mobile">Mobile number</label>
            <input type="number" id="mobile" placeholder="Mobile number" name="customer_mobile" class="form-control" required>
          </div>

          
          <div class="col-12 col-md-6 mb-4">
            @if (count($products))
            <label for="product">Select product</label>
            {{-- Se pidió no pensar en funcionalidad sino más en integracion y buenas prácticas, por ello solo dejé 1 producto --}}
            <select name="product_id" id="product" class="form-select" required>
              @foreach ($products as $product)
                  <option value="{{ $product->id }}">
                    {{ $product->product_name }} - {{ formatCurrency($products[0]->product_price, 'COP') }}
                  </option>
              @endforeach
            </select>
            @else
              <p>Please run <code class="ms-2 me-2">php artisan db:seed</code> to seed the products table.</p>
            @endif
          </div>
        </div>

        <p class="m-0 mb-4">
          <small>* All fields are required.</small>
        </p>

        @if (count($products))
          <h5 class="m-0 mb-4">
            Total: {{ formatCurrency($products[0]->product_price, 'COP') }}
          </h5>

          <input type="hidden" name="total" value="{{ $product['product_price'] }}">

          <div class="form-group text-center">
            <button class="btn btn-lg btn-dark">Go checkout</button>
          </div>
        @endif
      </form>
    </div>
  </main>
@endsection
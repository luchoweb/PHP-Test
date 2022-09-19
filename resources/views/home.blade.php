@extends('layout')

@section('content')
    <main class="home pt-5 pb-5">
        <div class="container">
            <h2 class="text-center mb-5">Choose the option you want to review</h2>

            <ul class="list-unstyled m-0 p-0 d-flex align-items-center gap-5 justify-content-center">
                <li>
                    <a href="/orders" class="text-light btn btn-dark ps-5 pe-5 pt-4 pb-4">
                        List all orders
                    </a>
                </li>

                <li>
                    <a href="/orders/new" class="text-light btn btn-dark ps-5 pe-5 pt-4 pb-4">
                        New order
                    </a>
                </li>

                <li>
                    <a href="/orders/tracking" class="text-light btn btn-dark ps-5 pe-5 pt-4 pb-4">
                        Tracking order
                    </a>
                </li>
            </ul>
        </div>
    </main>
@endsection
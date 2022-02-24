@extends('master')
@section('content')
<div class="custom-product">
    <div class="col-sm-10">
        <div class="trending-wrapper">
            <h4> My Orders </h4>

            @foreach($orders as $product)
            <div class="row searched-item cart-list-divider">
            <div class="col-sm-3">
                <a href="detail/{{$product['id']}}">
                    <img class="trending-img" src="{{$product['gallery']}}">
                </a>
            </div>
            <div class="col-sm-4">
                <div class="">
                    <h2> Name: {{$product['name']}} </h2>
                    <h5> Delivery Status: {{$product['status']}} </h5>
                    <h5> Address: {{$product['address']}} </h5>
                    <h5> Payment Status: {{$product['payment_status']}} </h5>
                    <h5> Payment Method: {{$product['payment_method']}} </h5>
                </div>
            </div>
            </div>
            
            @endforeach
        </div>
    </div>
</div>
@endsection
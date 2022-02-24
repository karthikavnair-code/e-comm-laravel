@extends('master')
@section('content')
<div class="custom-product">
    <div class="col-sm-10">
        <table class="table">
            <tbody>
            <tr>
                <td>Amount</td>
                <td>{{$total}}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Delivery</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>{{$total + 10}}</td>
            </tr>
            </tbody>
        </table>

        <div>
            <form action="/placeorder" method="POST">
                @csrf
                <div class="form-group">     
                    <label>Enter Your Address</label> <br><br>             
                    <textarea class="form-control" name="address"> </textarea>
                </div>
                <div class="form-group">
                    <label>Payment Method</label> <br><br>
                    <input type="radio" value="online" name="payment"> <span>Online Payment</span> <br><br>
                    <input type="radio" value="emi"name="payment"> <span> EMI Payment </span> <br><br>
                    <input type="radio" value="cash" name="payment"> <span> Cash on Delivery </span> <br><br>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </div>
</div>
@endsection
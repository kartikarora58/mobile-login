@extends('layouts.app')
@section('content')
    @if(count($errors))
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <br/>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container">
    @if($error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endif
    @if($x)
        <div class="alert alert-success">
            <h4>An OTP has been sent to your number</h4>
        </div>
    @endif
    <form method="post" action="{{url('/mobile/login')}}">
        @csrf
        <div class="form-group">
            <label>Mobile Number:</label>
            @if($mobile)
            <input style="width: 50%" required type="text" name="mobile" class="form-control" value="{{$mobile}}">
            @else
            <input style="width: 50%" required type="text" name="mobile" class="form-control" >
            @endif
            <input type="hidden" name="original" value="{{$x}}">
            @if($x)
             <label>Enter OTP</label>
                <input type="text" class="form-control" style="width: 50%" name="otp">
            @endif
        </div>

        @if($error)
            <input type="submit" class="btn btn-primary" value="Send Again">
        @else
            <input type="submit" class="btn btn-primary">
        @endif
    </form>

</div>
@endsection

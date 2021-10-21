@extends('layouts.app')

@section('content')
<div class="container">
    <h5>Edit Invoice</h5>
    <div class="row">
        <div class="col-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <form action="{{ url('invoice') }}/{{$invoice->id}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="invoice_name">Name</label>
                    <input type="text" class="form-control" name="invoice_name" id="invoice_name" value="{{ $invoice->invoice_name }}">
                </div>
                <div class="form-group">
                    <label for="invoice_email">Email</label>
                    <input type="email" class="form-control" name="invoice_email" id="invoice_email"  value="{{ $invoice->invoice_email }}">
                </div>
                <div class="form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" name="invoice_number" id="invoice_number"  value="{{ $invoice->invoice_number }}">
                </div>
                <div class="form-group">
                    <label for="invoice_file">Invoice File</label>
                    <input type="file" class="form-control" name="invoice_file" id="invoice_file">
                    <small class="text-danger"><b>Upload only pdf, jpg, jpeg, png format, size of 500 kb *</b></small>
                    <a href="{{asset('storage/'.$invoice->invoice_file)}}" target="_blank" ><img src="{{asset('storage/'.$invoice->invoice_file)}}" alt="" srcset="" height="100px" width="100px"></a>                    
                </div>
                <div class="form-group">
                    <label for="invoice_rating">Rating</label>
                    <input type="number" min="1" max="5" class="form-control" name="invoice_rating" id="invoice_rating"  value="{{ old('invoice_rating') ? old('invoice_rating') : '1' }}">
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>    

        </div>
    </div>    
</div>
@endsection

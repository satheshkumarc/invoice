@extends('layouts.app')

@section('content')
<div class="container">
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
    @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    <div class="row">
        <div class="col-4">
            <form action="{{ url('invoice') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="invoice_name">Name</label>
                    <input type="text" class="form-control" name="invoice_name" id="invoice_name" value="{{ old('invoice_name') }}" placeholder="Enter name" autocomplete="false">
                </div>
                <div class="form-group">
                    <label for="invoice_email">Email</label>
                    <input type="email" class="form-control" name="invoice_email" id="invoice_email" value="{{ old('invoice_email') }}" placeholder="Enter email" autocomplete="false">
                </div>
                <div class="form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}" placeholder="Enter number" autocomplete="false">
                </div>
                <div class="form-group">
                    <label for="invoice_file">Invoice File</label>
                    <input type="file" class="form-control" name="invoice_file" id="invoice_file">
                    <small class="text-danger"><b>Upload only pdf, jpg, jpeg, png format, size of 500 kb *</b></small>
                </div>
                <div class="form-group">
                    <label for="invoice_rating">Rating</label>
                    <input type="number" min="1" max="5" class="form-control" name="invoice_rating" id="invoice_rating"  value="{{ old('invoice_rating') ? old('invoice_rating') : '1' }}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>    

        </div>
        <div class="col-8">
            <table class="table display">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Invoice File</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Mail Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <th scope="row">{{$invoice->id}}</th>
                    <td>{{$invoice->invoice_name}}</td>
                    <td>{{$invoice->invoice_email}}</td>
                    <td>{{$invoice->invoice_number}}</td>
                    <td><a href="{{asset('storage/'.$invoice->invoice_file)}}" target="_blank" ><img src="{{asset('storage/'.$invoice->invoice_file)}}" alt="" srcset="" height="100px" width="100px"></a></td>
                    <td>
                        <?php
                        for($i=1; $i<=$invoice->invoice_rating; $i++)
                        {
                            if($invoice->invoice_rating >= $i)
                            {
                                ?>
                                    <span style="font-size:150%;color:yellow;">&starf;</span>
                                <?php 
                            }
                        }
                        ?>                        
                    </td>
                    <td>
                        @if($invoice->invoice_mail == '1')
                            <span class="text-success">SENT</span>
                            <a href="{{url('invoice-mail')}}/{{$invoice->id}}" class="btn btn-primary">RE-SEND</a>
                        @else
                            <a href="{{url('invoice-mail')}}/{{$invoice->id}}" class="btn btn-success">SEND</a>
                        @endif
                    </td>
                    <td class="d-flex"><a href="{{url('invoice')}}/{{$invoice->id}}" class="btn btn-warning">EDIT</a> <form action="{{url('invoice')}}/{{$invoice->id}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="DELETE" class="btn btn-danger">
                    </form></td>
                </tr>
                @endforeach
            </tbody>
            </table>            
        </div>
    </div>    
</div>
@endsection

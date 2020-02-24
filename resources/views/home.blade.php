@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <form action="http://127.0.0.1:8000/api/v1/upload" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    Book title:
    <br />
    
    <input type="text" name="title" />
    <input type="text" name="categoryID" />
    <input type="text" name="uid" />


    <br /><br />
    Logo:
    <br />
    <input type="file" name="logo" />
    <br /><br />
    <input type="submit" value=" Save " />
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

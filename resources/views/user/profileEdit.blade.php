@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body   ">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in!

                    <form action="/api/v1/users/update" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br />

                        <fieldset>
                            <legend>Personal:</legend>
                            Name: <input type="text" name="name" ><br>
                            Email: <input type="text" name="email"><br>
                            Date of birth: <input type="date" name="dob"><br>
                            Gender: <select name="gender">
                                <option>Male</option>
                                <option>Female</option>
                                <option>x</option>  
                            </select><br>
                            Zip code: <input type="text" name="zippost"><br>
                            Profile Picture: <input type="file" name="profilePic">
                        </fieldset>

                              <fieldset>
                            <legend>Social Media:</legend>
                            Facebook: <input type="text" name="youtube" ><br>
                            Snapchat: <input type="text" name="snapchat" ><br>
                            Twitter: <input type="text" name="twitter" ><br>
                            Telegram: <input type="text" name="telegram" ><br>
                            Discord: <input type="text" name="discord" ><br>

                        </fieldset>
<input type="hidden" name="uid" value="{{ Auth::user()->id }}">  
<input type="hidden" name="usertype" value="2">  

                        <input type="submit" value=" Save " />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

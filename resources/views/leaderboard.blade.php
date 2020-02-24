@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Leaderboard</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

  <table>
    <thead>
        <tr>
            <th> Rank</th>
            <th> name</th>
        </tr>
    </thead>
    <tbody>
          <tr>
              <td> {{ Auth::user()->id }} </td>
              <td> {{ Auth::user()->name }} </td>
          </tr>
   </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

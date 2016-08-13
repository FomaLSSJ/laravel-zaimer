@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        Username : {{ $self->name }}
                    </div>
                    <div class="col-md-6">
                        Balance: {{ $self->balance }}
                    </div>
                    <hr/>
                    @if (count($errors) > 0)
                        <div class="col-md-12 alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('success_transfer'))
                        <div class="col-md-12 alert alert-success">
                            <p>{!! session('success_transfer') !!}</p>
                        </div>
                    @endif
                    @if(Session::has('error_transfer'))
                        <div class="col-md-12 alert alert-danger">
                            <p>{!! session('error_transfer') !!}</p>
                        </div>
                    @endif
                    <form method="POST" action="/dashboard/transfer" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="from" value="{{ $self->id }}" />
                        <div class="col-md-6 form-group">
                            <label for="amount">Amount</label>
                            <input class="form-control" type="number" name="amount" placeholder="Amount" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="touser">To user</label>
                            <select class="form-control" name="to">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">Name:{{ $user->name }} - Email:{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input class="btn btn-primary" type="submit" value="Transfer" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

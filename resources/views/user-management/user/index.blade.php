@extends('layouts.master')

@section('content')
<div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif    
    <user-index></user-index>
</div>
@endsection

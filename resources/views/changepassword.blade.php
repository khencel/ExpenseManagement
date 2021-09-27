@extends('layouts.master')

@section('content')
<div class="">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <change-password/>
</div>
@endsection

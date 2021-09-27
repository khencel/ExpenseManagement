@extends('layouts.master')

@section('content')
<div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif    
    <category-index></category-index>
</div>
@endsection

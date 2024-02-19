@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Member Details
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $member->name }}</h5>
        <p class="card-text">Balance: {{ $member->balance }}</p>
        <p class="card-text">Location: {{ $member->location }}</p>
        <a href="{{ route('members.index') }}" class="btn btn-primary">Back to Members List</a>
    </div>
</div>
@endsection

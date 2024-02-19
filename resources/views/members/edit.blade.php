{{-- resources/views/members/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Member</h2>
    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Specify the method to use for updating --}}

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
        </div>

        <div class="form-group">
            <label for="balance">Balance:</label>
            <input type="number" class="form-control" id="balance" name="balance" value="{{ $member->balance }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $member->location }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Member</button>
    </form>
</div>
@endsection

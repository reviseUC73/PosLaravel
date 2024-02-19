@extends('layouts.app')

@section('content')
<h2>Add New Member</h2>
<form action="{{ route('members.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="balance">Balance:</label>
        <input type="number" class="form-control" id="balance" name="balance" required>
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <button type="submit" class="btn btn-success">Add Member</button>
</form>
@endsection

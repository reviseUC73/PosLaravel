{{-- Edit Item Form --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Item</h2>
    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description (optional):</label>
            <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

{{-- resources/views/members/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h2>Members List</h2>
<a href="{{ route('members.create') }}" class="btn btn-success mb-3">Add New Member</a>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Balance</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($members as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->balance }}</td>
            <td>{{ $member->location }}</td>
            <td>
                <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

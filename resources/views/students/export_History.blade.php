@extends('layouts.app')
@section('style')
<style>
    table,
    td,
    th {
        border: 2px solid black;
        border-collapse: collapse;
        padding: 5px;
        margin: auto;
        margin-top: 50px;
    }
    h2 {
        text-align: center;
        margin-top: 50px;
    }
</style>


@endsection

@section( 'content')
<h2>Export Task History</h2>

<table>
    <tr>
        <th>Id</th>
        <th>User</th>
        <th>File</th>
        <th>Status</th>
        <th>Initiated At</th>
        <th>Completed At</th>
        <th>Download</th>
    </tr>

    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->id}}</td>
        <td>{{ $task->user->name ?? 'System' }}</td>
        <td>{{ $task->file_name }}</td>
        <td>{{ $task->status }}</td>
        <td>{{ $task->initiated_at }}</td>
        <td>{{ $task->completed_at }}</td>
        <td>
            @if($task->status == 'completed')
            <a href="{{ asset('storage/exports/' . $task->file_name) }}" download>Download</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection
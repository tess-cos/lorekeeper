@extends('admin.layout')

@section('admin-title') Dialogue @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Dialogue' => 'admin/dialogue']) !!}

<h1>Dialogue</h1>

<p>This is a list of dialogue trees in the game. Each tree should be it's own 'conversation'.</p>

<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/dialogue/character-images') }}"><i class="fas fa-pencil-alt"></i> Create New Character Dialogue Image</a>
    <a class="btn btn-primary" href="{{ url('admin/dialogue/create') }}"><i class="fas fa-plus"></i> Create New Tree</a>
</div>

@if(!count($dialogues))
    <p>No dialogue found.</p>
@else
    {!! $dialogues->render() !!}
    <table class="table table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dialogue Name</th>
                <th>Speaker Name</th>
                <th>Dialogue</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dialogues as $dialogue)
                <tr>
                    <td>#{{ $dialogue->id }}</td>
                    <td>{{ $dialogue->dialogue_name }}</td>
                    <td>{{ $dialogue->speaker_name }}</td>
                    <td>{{ Illuminate\Support\Str::limit($dialogue->dialogue, 50, $end='...') }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('admin/dialogue/edit/'.$dialogue->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $dialogues->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $dialogues->total() }} result{{ $dialogues->total() == 1 ? '' : 's' }} found.</div>
@endif

@endsection

@section('scripts')
@parent
@endsection

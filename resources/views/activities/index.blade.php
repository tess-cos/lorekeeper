@extends('activities.layout')

@section('activities-title') Shop Index @endsection

@section('activities-content')
{!! breadcrumbs([ucfirst(__('dailies.dailies')) => __('dailies.dailies'), 'Activities' => 'activities']) !!}

<h1>
    Activities
</h1>

@include('activities._activities_list')

@endsection

@extends('layouts.app')

@section('title') Questionnaires @endsection

@section('content')
{!! breadcrumbs(['Questionnaires' => 'questionnaires']) !!}
<h1>Questionnaires</h1>
@if(count($forms))
    {!! $forms->render() !!}
    @foreach($forms as $form)
        @include('forms._site_form', ['form' => $form, 'page' => FALSE])
    @endforeach
    {!! $forms->render() !!}
@else
    <div>No questionnaires were posted yet.</div>
@endif
@endsection

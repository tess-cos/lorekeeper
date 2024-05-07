@extends('layouts.app')

@section('title') {{ $form->title }} @endsection

@section('content')

{!! breadcrumbs(['Questionnaires' => 'questionnaires', $form->title => $form->url]) !!}
@include('forms._site_form', ['form' => $form, 'page' => TRUE])

@endsection
    

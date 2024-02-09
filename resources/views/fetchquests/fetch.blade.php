@extends('layouts.app')

@section('title') Help Wanted @endsection

@section('content')

{!! breadcrumbs([ucfirst(__('dailies.dailies')) => __('dailies.dailies'), 'Help Wanted' => 'Help Wanted']) !!}

<h1>Help Wanted</h1>
<p>Courtesy of the Watcher's Guild, this is a magic notice for an item requested by a cossetling in need.</p><p>You can fulfill the request by turning in the item for some gratitude!
Requests change daily so make sure to check back.</p>

<div class="row" style="width: 85%; margin: auto;">
@if(isset($help) && $help)
<h3>✿ @if($help->name) {!! $help->name !!} @else {!! $help->displayname !!} @endif has a request!</h3>
<div class="col-sm-6">
            <div>
                <a href="{{ $help->url }}"><img src="{{ $help->image->thumbnailUrl }}" class="img-thumbnail" /></a>
            </div>
            <div class="mt-1">
                <a href="{{ $help->url }}" class="h5 mb-0">@if(!$help->is_visible) <i class="fas fa-eye-slash"></i> @endif</a>
            </div>
        @else
            <p>There is no helped character.</p>
        @endif</div>

<div class="col-md-6" style="align-content: center;"><center>@if(isset($fetchItem) && $fetchItem)
        @if($fetchItem->imageUrl)
        <div class="card" style="margin-top: 30px; margin-bottom: 30px;">
            <a href="{{ $fetchItem->url }}"><img style="max-width: 100%;" src="{{ $fetchItem->imageUrl}}"/></a>
        </div>
        @endif
        <div class="mt-1">
            <a href="{{ $fetchItem->url }}" class="h5 mb-0"> {{ $fetchItem->name }}</a>
        </div>
        @else
            <p>There is no fetch item.</p>
    @endif</center></div></div>

    <div style="width: 65%; margin: auto; margin-top: 10px;">
<h4 style="float: left; margin-right: 10px;">Reward:</h4>
    @if(isset($fetchCurrency) && $fetchCurrency && $fetchRewardmax && $fetchReward)
    <div style="padding-top: 2.5px; padding-bottom: 2.5px;">{!! $fetchCurrency->display($fetchCurrency->name) !!}</div>
        @else
            <p>There is no reward.</p>
        @endif
            @if(isset($fetchCurrency) && $fetchCurrency && $fetchRewardmax && $fetchReward && !Auth::user()->fetchCooldown)
            <div class="text-right">
                <a href="#" class="btn btn-primary" id="submitButton">Lend a hand!</a>
            </div>
            @elseif(Auth::user()->fetchCooldown)
            <div class="alert-secondary" style="padding: 5px; border-radius: 5px;"> You can complete another request {!! pretty_date(Auth::user()->fetchCooldown) !!}!</div>
            @else
            <div style="padding-top: 2.5px;"> You can't turn in a quest with no reward!</div>
            @endif

        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h5 mb-0">Confirm  Submission</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>This will submit the request, remove the item asked for, and add currency to your account. Are you sure?</p>
                    {!! Form::open(['url' => 'helpwanted/new']) !!}
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div></div>
@endsection

@section('scripts')
@parent 
    <script>
        $(document).ready(function() {
            var $submitButton = $('#submitButton');
            var $confirmationModal = $('#confirmationModal');
            var $formSubmit = $('#formSubmit');
            
            $submitButton.on('click', function(e) {
                e.preventDefault();
                $confirmationModal.modal('show');
            });

            $formSubmit.on('click', function(e) {
                e.preventDefault();
                $submissionForm.submit();
            });

            $('.is-br-class').change(function(e){
            console.log(this.checked)
            $('.br-form-group').css('display',this.checked ? 'block' : 'none')
                })
            $('.br-form-group').css('display',$('.is-br-class').prop('checked') ? 'block' : 'none')
        });
    </script>
@endsection
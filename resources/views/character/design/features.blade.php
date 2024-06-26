@extends('character.design.layout')

@section('design-title') Design Approval Request (#{{ $request->id }}) :: Comments @endsection

@section('design-content')
{!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Traits' => 'designs/' . $request->id . '/traits']) !!}

@include('character.design._header', ['request' => $request])

<h2>Traits</h2>

@if($request->status == 'Draft' && $request->user_id == Auth::user()->id)
    <p>Select the traits for the {{ $request->character->is_myo_slot ? 'created' : 'updated' }} character. @if($request->character->is_myo_slot) Some traits may have been restricted for you - you cannot change them. @endif Staff will not be able to modify these traits for you during approval, so if in doubt, please communicate with them beforehand to make sure that your design is acceptable.
        Once you save, the traits will be locked in.
    </p>
    {!! Form::open(['url' => 'designs/'.$request->id.'/traits']) !!}
        <div class="form-group">
            {!! Form::label('species_id',  ucfirst(__('lorekeeper.species'))) !!}
            @if($request->character->is_myo_slot && $request->character->image->species_id)
                <div class="alert alert-secondary">{!! $request->character->image->species->displayName !!}</div>
            @else
                {!! Form::select('species_id', $specieses, $request->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('transformation_id', 'Charm') !!}
            @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
                <div class="alert alert-secondary">{!! $request->character->image->transformation->displayName !!}</div>
            @else
                <div id="transformations">
                    {!! Form::select('transformation_id', $transformations, $request->transformation_id, ['class' => 'form-control', 'id' => 'transformation']) !!}
                </div>
            @endif
        </div>

            <p class="alert alert-danger">You cannot select a subtype.</p>

        <div class="form-group">
            {!! Form::label('rarity_id', 'Character Rarity') !!}
            @if($request->character->is_myo_slot && $request->character->image->rarity_id)
                <div class="alert alert-secondary">{!! $request->character->image->rarity->displayName !!}</div>
            @else
                {!! Form::select('rarity_id', $rarities, $request->rarity_id, ['class' => 'form-control', 'id' => 'rarity']) !!}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label(ucfirst(__('character_theme.theme')).' ' . (config('lorekeeper.extensions.character_theme.is_required') ? '(Required)' : '(Optional)')) !!}
            {!! Form::text('theme', $request->theme, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Traits') !!}
            @if(Settings::get('trait_per_item') == 0 && count($request->getAttachedTraitIds()) > 0 )<div><a href="#" class="btn btn-primary mb-2" id="add-feature">Add Trait</a></div>
            @else
            <i>You must attach a trait item in order to pick new traits for your character.</i>
            @endif

            <div id="featureList">
                {{-- Add in the compulsory traits for MYO slots --}}
                @if($request->character->is_myo_slot && $request->character->image->features)
                    @foreach($request->character->image->features as $feature)
                        <div class="mb-2 d-flex align-items-center">
                            {!! Form::text('', $feature->name, ['class' => 'form-control mr-2', 'disabled']) !!}
                            {!! Form::text('', $feature->data, ['class' => 'form-control mr-2', 'disabled']) !!}
                            <div>{!! add_help('This trait is required.') !!}</div>
                        </div>
                    @endforeach
                @endif
                {{-- Add in the ones that currently exist --}}
                @if($request->features)
                    @foreach($request->features as $feature)
                        <div class="mb-2 d-flex">
                            <!--- Users no longer assign traits, this is done via addon trait item! Hence, turn this readonly --->
                            {!! Form::select('feature_id[]', $features, $feature->feature_id, ['class' => 'form-control mr-2 feature-select', 'readonly', 'style' => 'pointer-events: none;']) !!}
                            {!! Form::text('feature_data[]', $feature->data, ['class' => 'form-control mr-2', 'readonly']) !!}
                            @if($request->canRemoveTrait() || Settings::get('trait_remover_needed') == 0 )<a href="#" class="remove-feature btn btn-danger mb-2">×</a>@endif
                        </div>
                    @endforeach
                @endif
                @if(count($itemFeatures) > 0)
                    @foreach($itemFeatures as $itemFeature)
                        <div class="mb-2 d-flex">
                            <!--- These selects are built based on the trait item added and only allow the specified traits to be chosen! --->
                            {!! Form::select('feature_id[]', $itemFeature, array_key_first($itemFeature), ['class' => 'form-control mr-2 feature-select']) !!}
                            {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="feature-row hide mb-2">
                {!! Form::select('feature_id[]', $choiceFeatures, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Trait']) !!}
                {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@else
    <div class="mb-1">
        <div class="row">
            <div class="col-md-2 col-4"><h5>{{ ucfirst(__('lorekeeper.species')) }}</h5></div>
            <div class="col-md-10 col-8">{!! $request->species ? $request->species->displayName : 'None Selected' !!}</div>
        </div>
        @if($request->subtype_id || ($request->character->is_myo_slot && $request->character->image->subtype_id))
        <div class="row">
            <div class="col-md-2 col-4"><h5>{{ ucfirst(__('lorekeeper.subtype')) }}</h5></div>
            <div class="col-md-10 col-8">
            @if($request->character->is_myo_slot && $request->character->image->subtype_id)
                {!! $request->character->image->subtype->displayName !!}
            @else
                {!! $request->subtype_id ? $request->subtype->displayName : 'None Selected' !!}
            @endif
            </div>
        </div>
        @endif
        @if($request->transformation_id)
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>{{ ucfirst(__('transformations.transformation')) }}</h5>
                    </div>
                    <div class="col-md-10 col-8">
                        @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
                            {!! $request->character->image->transformation->displayName !!}
                        @else
                            {!! $request->transformation_id ? $request->transformation->displayName : 'None Selected' !!}
                        @endif
                    </div>
                </div>
        @endif
        @if($request->subtype_id_2 || ($request->character->is_myo_slot && $request->character->image->subtype_id_2))
        <div class="row">
            <div class="col-md-2 col-4"><h5>Subtype</h5></div>
            <div class="col-md-10 col-8">
            @if($request->character->is_myo_slot && $request->character->image->subtype_id_2)
                {!! $request->character->image->subtypeTwo->displayName !!}
            @else
                {!! $request->subtype_id_2 ? $request->subtypeTwo->displayName : 'None Selected' !!}
            @endif
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-2 col-4"><h5>Rarity</h5></div>
            <div class="col-md-10 col-8">{!! $request->rarity ? $request->rarity->displayName : 'None Selected' !!}</div>
        </div>
        @if($request->theme)
            <div class="row">
                <div class="col-md-2 col-4"><h5>{{ucfirst(__('character_theme.theme'))}}</h5></div>
                <div class="col-md-10 col-8">{!! $request->theme !!}</div>
            </div>
        @endif
    </div>
    <h5>Traits</h5>
    <div>
        @if($request->character && $request->character->is_myo_slot && $request->character->image->features)
            @foreach($request->character->image->features as $feature)
                <div>@if($feature->feature->feature_category_id) <strong>{!! $feature->feature->category->displayName !!}:</strong> @endif {!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif <span class="text-danger">*Required</span></div>
            @endforeach
        @endif
        @foreach($request->features as $feature)
            <div>@if($feature->feature->feature_category_id) <strong>{!! $feature->feature->category->displayName !!}:</strong> @endif {!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
        @endforeach
    </div>
@endif

@endsection

@section('scripts')
@include('widgets._image_upload_js')

<script>
  $( "#species" ).change(function() {
    var species = $('#species').val();
    var id = '<?php echo($request->id); ?>';
    $.ajax({
      type: "GET", url: "{{ url('designs/traits/subtype') }}?species="+species+"&id="+id, dataType: "text"
    }).done(function (res) { $("#subtypes").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    $.ajax({
      type: "GET", url: "{{ url('designs/traits/subtype') }}?species="+species+"&id="+id, dataType: "text"
    }).done(function (res) { $("#subtypes_2").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
  });
</script>

@endsection

{{-- Image Data --}}
<div class="col-md-5 d-flex">
    <div class="card character-bio w-100">
        <div class="card-header cc-4 gbg" style="background: none !important; border-bottom: 1px solid #f4e3e6;">
            <ul class="nav nav-tabs card-header-tabs" style="background: none !important;">
                <li class="nav-item">
                    <a class="nav-link active" id="infoTab-{{ $image->id }}" data-toggle="tab" href="#info-{{ $image->id }}" role="tab">Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notesTab-{{ $image->id }}" data-toggle="tab" href="#notes-{{ $image->id }}" role="tab">Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="creditsTab-{{ $image->id }}" data-toggle="tab" href="#credits-{{ $image->id }}" role="tab">Credits</a>
                </li>
                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <li class="nav-item">
                        <a class="nav-link" id="settingsTab-{{ $image->id }}" data-toggle="tab" href="#settings-{{ $image->id }}" role="tab"><i class="fas fa-cog"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="text-right mb-1">
                <div class="badge badge-primary">Image #{{ $image->id }}</div>
            </div>
            @if(!$image->character->is_myo_slot && !$image->is_valid)
                <div class="alert alert-danger">
                    This version of this {{ __('lorekeeper.character') }} is outdated, and only noted here for recordkeeping purposes. Do not use as an official reference.
                </div>
            @endif

            {{-- Basic info  --}}
            <div class="tab-pane fade show active" id="info-{{ $image->id }}">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; display: none;">Class</div>
                    <div class="col-lg-8 col-md-6 col-8" style="display: none;">{!! $image->character->class_id ? $image->character->class->displayName : 'None' !!} 
                        @if(Auth::check())
                        @if(Auth::user()->isStaff || Auth::user()->id == $image->character->user_id && $image->character->class_id == null) 
                        <a href="#" class="btn btn-outline-info btn-sm edit-class ml-1" data-id="{{ $image->character->id }}"><i class="fas fa-cog"></i></a>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Species</div>
                    <div class="col-lg-8 col-md-6 col-8">{!! $image->species_id ? $image->species->displayName : 'None' !!}</div>
                </div>
                @if($image->subtype_id)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Subtype{{ ($image->subtype_id_2) ? 's' : '' }}</div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->subtype_id ? $image->subtype->displayName : 'None' !!} {{($image->subtype_id_2) ? '•' : '' }} {!! $image->subtype_id_2 ? $image->subtypeTwo->displayName : '' !!}</div>
                    </div>
                @endif
                @if ($image->transformation_id)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">
                            {{ (ucfirst(__('transformations.transformation'))) }} {!! add_help('The main image is always the active image') !!}
                        </div>
                        <div class="col-lg-8 col-md-6 col-8">
                            <a href="{{ $image->transformation->url }}">
                                {!! $image->transformation->displayName !!}
                            </a>
                        </div>
                    </div>
                @endif
                @if($image->character->homeSetting)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Home</div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->character->location ? $image->character->location : 'None' !!}</div>
                    </div>
                @endif
                @if($image->character->factionSetting)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Faction</div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->character->faction ? $image->character->currentFaction : 'None' !!}{!! $character->factionRank ? ' ('.$character->factionRank->name.')' : null !!}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Rarity</div>
                    <div class="col-lg-8 col-md-6 col-8">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!}</div>
                </div>
                @if($image->theme)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">{{ucfirst(__('character_theme.theme'))}}</div>
                        <div class="col-lg-8 col-md-6 col-8 asp">{!! $image->theme !!}</div>
                    </div>
                @endif

                <div class="mb-3">
                    <div style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d; margin-top: 5px;">Traits</div>
                    @if(Config::get('lorekeeper.extensions.traits_by_category'))
                        <div style="font-size: 9pt;">
                            @php $traitgroup = $image->features()->get()->groupBy('feature_category_id') @endphp
                            @if($image->features()->count())
                                @foreach($traitgroup as $key => $group)
                                <div class="mb-2">
                                    @if($key)
                                        <strong>{!! $group->first()->feature->category->displayName !!}:</strong>
                                    @else
                                        <strong>Miscellaneous:</strong>
                                    @endif
                                    @foreach($group as $feature)
                                        <div class="ml-md-2">{!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
                                    @endforeach
                                </div>
                                @endforeach
                            @else
                                <div>No traits listed.</div>
                            @endif
                        </div>
                    @else
                        <div>
                            <?php $features = $image->features()->with('feature.category')->get(); ?>
                            @if($features->count())
                                @foreach($features as $feature)
                                    <div>@if($feature->feature->feature_category_id) <strong>{!! $feature->feature->category->displayName !!}:</strong> @endif {!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
                                @endforeach
                            @else
                                <div>No traits listed.</div>
                            @endif
                        </div>
                    @endif
                </div>
                <hr>
                <div style="color: #E5C1C7;">
                    <small><strong>Uploaded:</strong> {!! pretty_date($image->created_at) !!}</small>
                </div>
                <div style="color: #E5C1C7; margin-top: -5px;">
                <small><strong>Last Edited:</strong> {!! pretty_date($image->updated_at) !!}</small>
                </div>

                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-features mb-3" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>
                    </div>
                @endif
                <div class="mb-1" style="display: none;">
                    <div><h5>Gear</h5></div>
                        <div class="text-center row">
                        @foreach($image->character->gear as $gear)
                            <div class="ml-3 mr-3">
                                @if($gear->has_image)
                                <img src="{{ $gear->imageUrl }}" data-toggle="tooltip" title="{{ $gear->gear->name }}" style="max-width: 75px;"/>
                                @elseif($gear->gear->imageurl)
                                <img src="{{ $gear->gear->imageUrl }}" data-toggle="tooltip" title="{{ $gear->gear->name }}" style="max-width: 75px;"/>
                                @else {!!$gear->gear->displayName !!}
                                @endif
                            </div>
                        @endforeach
                        </div>
                </div>

                <div class="mb-1" style="display: none;">
                    <div><h5>Weapons</h5></div>
                        <div class="text-center row">
                        @foreach($image->character->weapons as $weapon)
                            <div class="ml-3 mr-3">
                                @if($weapon->has_image)
                                <img src="{{ $weapon->imageUrl }}" data-toggle="tooltip" title="{{ $weapon->weapon->name }}" style="max-width: 75px;"/>
                                @elseif($weapon->weapon->imageurl)
                                <img src="{{ $weapon->weapon->imageUrl }}" data-toggle="tooltip" title="{{ $weapon->weapon->name }}" style="max-width: 75px;"/>
                                @else {!!$weapon->weapon->displayName !!}
                                @endif
                            </div>
                        @endforeach
                        </div>
                </div>
            </div>

            {{-- Image notes --}}
            <div class="tab-pane fade" id="notes-{{ $image->id }}">
                @if($image->parsed_description)
                    <div class="parsed-text imagenoteseditingparse">{!! $image->parsed_description !!}</div>
                @else
                    <div class="imagenoteseditingparse">No additional notes given.</div>
                @endif
				@if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-notes" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>
                    </div>
				@endif
            </div>

            {{-- Image credits --}}
            <div class="tab-pane fade" id="credits-{{ $image->id }}">

                <div class="row mb-2">
                    <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Design</div>
                    <div class="col-lg-8 col-md-6 col-8 hd">
                        @foreach($image->designers as $designer)
                            <div>{!! $designer->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Art</div>
                    <div class="col-lg-8 col-md-6 col-8 hd">
                        @foreach($image->artists as $artist)
                            <div>{!! $artist->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>

                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-credits" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>
                    </div>
                @endif
            </div>

            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="tab-pane fade" id="settings-{{ $image->id }}">
                    {!! Form::open(['url' => 'admin/character/image/'.$image->id.'/settings']) !!}
                        <div class="form-group">
                            {!! Form::checkbox('is_visible', 1, $image->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('is_visible', 'Is Viewable', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will not be visible by anyone without the Manage Masterlist power.') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('is_valid', 1, $image->is_valid, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('is_valid', 'Is Valid', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will still be visible, but displayed with a note that the image is not a valid reference.') !!}
                        </div>
                        <div class="text-right">
                            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                    <hr />
                    <div class="text-right">
                    @if($character->character_image_id != $image->id) <a href="#" class="btn btn-outline-info btn-sm active-image" data-id="{{ $image->id }}">Set Active</a> @endif <a href="#" class="btn btn-outline-info btn-sm reupload-image" data-id="{{ $image->id }}">Reupload Image</a> <a href="#" class="btn btn-outline-danger btn-sm delete-image" data-id="{{ $image->id }}">Delete</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>


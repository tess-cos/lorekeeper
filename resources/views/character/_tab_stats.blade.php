<div class="row">
    <div class="col-lg-3 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Owner</div>
    <div class="col-lg-9 col-8">{!! $character->displayOwner !!}</div>
</div>
@if(!$character->is_myo_slot)
    <div class="row">
        <div class="col-lg-3 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Category</div>
        <div class="col-lg-9 col-8">{!! $character->category->displayName !!}</div>
    </div>
@endif
<div class="row">
    <div class="col-lg-3 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Created</div>
    <div class="col-lg-9 col-8">{!! format_date($character->created_at) !!}</div>
</div>

<hr />

<div style="font-family: Poppins, serif;text-transform: lowercase; font-size: 9.5pt;"><i class="text-{{ $character->is_giftable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_giftable ? 'Can' : 'Cannot'  }} be gifted</div>
<div style="font-family: Poppins, serif;text-transform: lowercase; font-size: 9.5pt;"><i class="text-{{ $character->is_tradeable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_tradeable ? 'Can' : 'Cannot'  }} be traded</div>
<div style="font-family: Poppins, serif;text-transform: lowercase; font-size: 9.5pt;"><i class="text-{{ $character->is_sellable ? 'success far fa-circle' : 'danger fas fa-times'  }} fa-fw mr-2"></i> {{ $character->is_sellable ? 'Can' : 'Cannot'  }} be sold</div>
<div class="row">
    <div class="col-lg-3 col-4" style="font-family: Poppins, serif;text-transform: lowercase; font-weight: bold; font-size: 10.5pt;">Sale Value</div>
    <div class="col-lg-9 col-8">{{ Config::get('lorekeeper.settings.currency_symbol') }}{{ $character->sale_value }}</div>
</div>
@if($character->transferrable_at && $character->transferrable_at->isFuture())
    <div class="row">
        <div class="col-lg-3 col-4" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt;">Cooldown</div>
        <div class="col-lg-9 col-8">Cannot be transferred until {!! format_date($character->transferrable_at) !!}</div>
    </div>
@endif
@if(Auth::check() && Auth::user()->hasPower('manage_characters'))
    <div class="mt-3">
        <a href="#" class="btn btn-outline-info btn-sm edit-stats" data-{{ $character->is_myo_slot ? 'id' : 'slug' }}="{{ $character->is_myo_slot ? $character->id : $character->slug }}"><i class="fas fa-cog"></i> Edit</a>
    </div>
@endif

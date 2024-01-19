@extends('home.user_shops.layout')

@section('home.user_shops-title') Farmer's Market @endsection

@section('home.user_shops-content')
{!! breadcrumbs(['Farmers Market' => 'usershops/shop-index']) !!}

<h1>
    Farmer's Market
</h1>
<p>This is a catalog of all user-owned shops, seperate from official site <a href="{{ url('shops') }}">shops</a>, that sell various goods you can purchase.</p>
<div class="text-right mb-3">
        <a class="btn btn-primary" href="{{ url('usershops/item-search') }}"><i class="fas fa-search"></i> Search For an Item</a>
        <a class="btn btn-primary" href="{{ url('usershops/pet-search') }}"><i class="fas fa-search"></i> Search For a Pet</a>
</div>

<div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div> 
        <div class="form-group mr-3 mb-3">
            {!! Form::select('sort', [
                'alpha'          => 'Sort Alphabetically (A-Z)',
                'alpha-reverse'  => 'Sort Alphabetically (Z-A)',
                'newest'         => 'Newest First',
                'oldest'         => 'Oldest First'    
            ], Request::get('sort') ? : 'category', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>
{!! $shops->render() !!}
<div class="row shops-row">
            @foreach($shops as $shop)
                <div class="col-md-3 col-6 mb-3 text-center">
                    @if($shop->has_image)
                        <div class="shop-image container">
                            <a href="{{ $shop->url }}">
                                <img src="{{ $shop->shopImageUrl }}" style="max-width: 200px !important; max-height: 200px !important;" alt="{{ $shop->name }}" />
                            </a>
                        </div>
                    @endif
                    <div class="shop-name mt-1">
                        <a href="{{ $shop->url }}" class="h5 mb-0">{{ $shop->name }}</a>
                        <br>
                        Owned by <a href="{{ $shop->user->url }}">{!! $shop->user->displayName !!}</a>
                    </div>
                </div>
            @endforeach
        </div>
{!! $shops->render() !!}

<div class="text-center mt-4 small text-muted">{{ $shops->total() }} result{{ $shops->total() == 1 ? '' : 's' }} found.</div>

    <div class="text-right mb-4">
        <a href="{{ url('usershops/history') }}">View purchase logs...</a>
</div>


@endsection

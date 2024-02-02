{!! Form::open(['url' => 'activities/' . $activity->id . '/act']) !!}
<h3>Select Items to Turn In</h3>
@if($activity->data->quantity)
<p>You are required to select {{ $activity->data->quantity }} item(s) to turn in.</p>
@endif
<h3>Inventory <a class="small inventory-collapse-toggle collapse-toggle" href="#inventturnin" data-toggle="collapse">Show</a></h3>
<hr>
    <div class="collapse collapse" id="inventturnin">
@include('widgets._inventory_select_sc', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => [], 'hideCollapse' => true])
<div class="text-right">
    {!! Form::submit('Turn in Items', ['class' => 'btn btn-primary']) !!}
</div></div>

{!! Form::close() !!}

@include('widgets._inventory_select_sc_js')
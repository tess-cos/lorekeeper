
<div class="dash row justify-content-center" >
  <div class="top1"><div class="card mb-4 timestamp" style="padding: 15px; border: 0px;">
 <img src="/images/avatars/{{ Auth::user()->avatar }}" style="float: left; max-width: 100px; max-height: 100px; border-radius: 999px; border: 2.5px dashed #E5C1C7;">
</div></div>
  <div class="top2"><div class="top2txt"><h3>Welcome, <a style="color: #95b582;">{!! Auth::user()->displayName !!}</a>!</h3>
        <div style="font-size: 9pt; font-weight: bold; color:#95b582;"> <i class="far fa-clock"></i> {!! format_date(Carbon\Carbon::now()) !!}</div>
    </div></div>
</div>
<div class="dash row justify-content-center" >
  <div class="top1">
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ Auth::user()->url }}">Profile</a></li>
                <li class="list-group-item"><a href="{{ url('account/settings') }}">User Settings</a></li>
                <li class="list-group-item"><a href="{{ url('trades/open') }}">Trades</a></li>
            </ul></div>
  <div class="top2">
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('characters') }}">My Characters</a></li>
                <li class="list-group-item"><a href="{{ url('characters/myos') }}">My MYO Slots</a></li>
                <li class="list-group-item"><a href="{{ url('characters/transfers/incoming') }}">Character Transfers</a></li>
            </ul></div>
</div>

<div class="dash row justify-content-center" >
  <div class="top1">
  <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ url('bank') }}">Bank</a></li>
                <li class="list-group-item"><a href="{{ url('inventory') }}">My Inventory</a></li>
                <li class="list-group-item"><a href="{{ url(__('awards.awardcase')) }}">My {{ ucfirst(__('awards.awards')) }}</a></li>
            </ul></div>
  <div class="top2">
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/currency-logs' }}">Currency Logs</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/item-logs' }}">Item Logs</a></li>
                <li class="list-group-item"><a href="{{ Auth::user()->url . '/'.__('awards.award').'-logs' }}">{{ ucfirst(__('awards.award')) }} Logs</a></li>
            </ul></div>
</div>

<div class="dash row justify-content-center">
  <div class="top1"><div class="card mb-4 timestamp" style="padding: 15px; border: 0px;">
 <img src="/images/avatars/{{ Auth::user()->avatar }}" style="float: left; max-width: 100px; max-height: 100px; border-radius: 999px; border: 2.5px solid #f4e3e6;">
</div></div>
  <div class="top2"><div class="top2txt"><h3>Welcome, <a style="color: #95b582;">{!! Auth::user()->displayName !!}</a>!</h3>
        <div style="font-size: 9pt; font-weight: bold; color:#95b582;"> <i class="far fa-clock"></i> {!! LiveClock() !!}</div>
    </div></div>
  </div>

  <div style="width: 80%; margin: auto;">
    <center><a href="{{ Auth::user()->url }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">profile</a>
<a href="{{ url('account/settings') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">settings</a>
<a href="{{ url('trades/open') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">trades</a>

<a href="{{ url('bank') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">bank</a>
<a href="{{ url('inventory') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">inventory</a>
<a href="{{ url(__('awards.awardcase')) }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6">{{ ucfirst(__('awards.awards')) }}</a></center></div>



<div class="dash row justify-content-center" style="width: 84%; background-image: none;">
<div class="top3"><br />
  @include('widgets._news', ['textPreview' => true])
  </div>
  <div class="top4">
  @include('widgets._selected_character_dash', ['character' => Auth::user()->settings->selectedCharacter, 'user' => Auth::user(), 'fullImage' => true])
  </div>
</div>

<div style="width: 90%; margin: auto;">
    <center><a href="{{ url('characters') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">characters</a>
<a href="{{ url('characters/myos') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">myo slots</a>
<a href="{{ url('characters/transfers/incoming') }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">character transfers</a>

<a href="{{ Auth::user()->url . '/currency-logs' }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">Currency Logs</a>
<a href="{{ Auth::user()->url . '/item-logs' }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">item logs</a>
<a href="{{ Auth::user()->url . '/'.__('awards.award').'-logs' }}" class="btn" style="font-family: Mali, serif; text-transform: lowercase; background-color: #f4e3e6;">{{ ucfirst(__('awards.award')) }} Logs</a></center></div>


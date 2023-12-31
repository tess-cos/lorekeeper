
<div class="dash row justify-content-center">
  <div class="top1"><div class="card mb-4 timestamp" style="padding: 15px; border: 0px;">
 <img class="dimg" src="/images/avatars/{{ Auth::user()->avatar }}" style="float: left; max-width: 100px; max-height: 100px; border-radius: 999px; border: 2.5px solid #f4e3e6;">
</div></div>
  <div class="top2"><div class="top2txt"><h3 class="dt">Welcome, <a style="color: #95b582;">{!! Auth::user()->displayName !!}</a>!</h3>
        <div style="font-size: 9pt; font-weight: bold; color:#95b582;"> <i class="far fa-clock"></i> {!! LiveClock() !!}</div>
    </div></div>
  </div>

<div class="dicn" style="width: 95%; margin: auto;">
<center>
<span class="dashd" style="color: #EDD3A0; margin: auto; font-size: 20pt; position: relative; top: 5px;">🙜</span>
<div class="dropdown" style="display: inline-block !important;">
  <button class="btn btn-dash dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    For You
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-transform: lowercase; font-size: 11pt; line-height: 25px; background-color: #fcfcfc !important;">
    <a class="dropdown-item" href="{{ Auth::user()->url }}">Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('account/settings') }}">Settings</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('inventory') }}">Inventory</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('bank') }}">Bank</a>
  </div>
</div>
<span class="dashdd" style="color: #EDD3A0; margin: auto; font-size: 20pt; position: relative; top: 5px;">🙜</span>
<div class="dropdown" style="display: inline-block !important;">
  <button class="btn btn-dash dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    To Dos
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-transform: lowercase; font-size: 11pt; line-height: 25px; background-color: #fcfcfc !important;">
    <a class="dropdown-item" href="{{ url(__('dailies.dailies')) }}">Dailies</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('prompts/prompts') }}">Prompts</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('spellcasting') }}">Spellcasting</a>
  </div>
</div>
<span class="dashdd" style="color: #EDD3A0; margin: auto; font-size: 20pt; position: relative; top: 5px;">🙜</span>
<div class="dropdown" style="display: inline-block !important;">
  <button class="btn btn-dash dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Other
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-transform: lowercase; font-size: 11pt; line-height: 25px; background-color: #fcfcfc !important;">
    <a class="dropdown-item" href="{{ url('info/guide') }}">Guidebook</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('info/rules') }}">Rules & FAQ</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('claims') }}">Claims</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ url('info/rfl') }}">Raffles</a>
  </div>
</div>
<span class="dashd" style="color: #EDD3A0; margin: auto; font-size: 20pt; position: relative; top: 5px;">🙜</span>
</center>
</div>


<div class="dash row justify-content-center" style="width: 84%; background-image: none;">
<div class="top3 dnew"><br />
  @include('widgets._news', ['textPreview' => true])
  </div>
  <div class="top4">
  @include('widgets._selected_character_dash', ['character' => Auth::user()->settings->selectedCharacter, 'user' => Auth::user(), 'fullImage' => true])
  </div>
</div>
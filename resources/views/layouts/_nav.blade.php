
<nav class="navbar navbar-expand-md navbar-light" id="headerNav">
<div class="clk">
        <i class="far fa-clock"></i> {!! LiveClock() !!}</div>
<div class="navimg"></div><br /><div class="navimgbg">.<br />.<br /></div><br />
    <div class="container-fluid">
        <a class="navbar-f" href="{{ url('/') }}">✿
        </a>
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_news_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex cc-1" href="{{ url('news') }}"><strong>News</strong><i class="fas fa-bell text-warning fa-bounce"></i></a>
                    @else
                        <a class="nav-link cc-1" style="color:#4A4A4A; font-size: 10pt;" href="{{ url('news') }}">News</a>
                    @endif
                </li>
                
                <li class="nav-item">
                    @if(Auth::check() && Auth::user()->is_sales_unread && Config::get('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex cc-1" href="{{ url('sales') }}"><strong>Sales</strong><i class="fas fa-bell text-warning fa-bounce"></i></a>
                    @else
                        <a class="nav-link cc-1" style="color:#4A4A4A; font-size: 10pt;" href="{{ url('sales') }}">Sales</a>
                    @endif
                </li>
                @if(Auth::check())
                    <li class="nav-item dropdown">
                        <a id="inventoryDropdown" class="nav-link dropdown-toggle cc-1" style="color:#4A4A4A; font-size: 10pt;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Home
                        </a>

                        <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
                            <a class="dropdown-item" href="{{ url('characters') }}">
                                My Characters
                            </a>
                            <a class="dropdown-item" href="{{ url('characters/myos') }}">
                                My MYO Slots
                            </a>
                            <a class="dropdown-item" href="{{ url('pets') }}">Pets</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('inventory') }}">
                                Inventory
                            </a>
                            <a class="dropdown-item" href="{{ url('bank') }}">
                                Bank
                            </a>
                            <a class="dropdown-item" href="{{ url('scrapbook') }}">
                                {{ ucfirst(__('awards.awards')) }}
                            </a>
                            <a class="dropdown-item" style="display: none;" href="{{ url('collection') }}">
                                Collections
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('wishlists') }}">
                                Wishlists
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="queueDropdown" class="nav-link dropdown-toggle cc-1" style="color:#4A4A4A; font-size: 10pt;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Activity
                        </a>
                        <div class="dropdown-menu" aria-labelledby="queueDropdown">
                        <a class="dropdown-item" href="{{ url('inbox') }}">
                                Inbox
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('submissions') }}">
                                Prompt Submissions
                            </a>
                            <a class="dropdown-item" href="{{ url('designs') }}">
                                Design Approvals
                            </a>
                            <a class="dropdown-item" href="{{ url('claims') }}">
                                Claims
                            </a>
                            <div class="dropdown-divider"></div>
                            @if(Auth::check())
                            @if(Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
                                <a class="dropdown-item" href="{{ url(Auth::user()->shops()->first()->editUrl) }}">
                                    My Shop Stock
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ url('user-shops') }}">
                                    My Shop
                                </a>
                            @endif
                        @endif
                        <a class="dropdown-item" href="{{ url('characters/transfers/incoming') }}">
                                Character Transfers
                            </a>
                            <a class="dropdown-item" href="{{ url('trades/open') }}">
                                Trades
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('reports') }}">
                                My Reports
                            </a>
                        </div>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="loreDropdown" class="nav-link dropdown-toggle cc-1" style="color:#4A4A4A; font-size: 10pt;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Play
                    </a>

                    <div class="dropdown-menu" aria-labelledby="loreDropdown">
                        <a class="dropdown-item" href="{{ url('prompts/prompts') }}">
                            Prompts
                            <a class="dropdown-item" href="{{ url('quests') }}">
                            Quests
                        </a>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url(__('dailies.dailies')) }}">
                        {{__('dailies.dailies')}}
                        </a>
                        <a class="dropdown-item" href="{{ url('traveling') }}">
                            Traveling
                        </a>
                        <a class="dropdown-item" href="{{ url('spellcasting') }}">
                                Spellcasting
                            </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('shops') }}">
                            Shops
                        </a>
                        <a class="dropdown-item" href="{{ url('/trades/listings') }}">
                            Trade Plaza
                        </a>
                        <a class="dropdown-item" href="{{ url('user-shops/shop-index') }}">
                            Farmer's Market
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('raffles') }}">
                            Raffles
</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="browseDropdown" class="nav-link dropdown-toggle cc-1" style="color:#4A4A4A; font-size: 10pt;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Browse
                    </a>

                    <div class="dropdown-menu" aria-labelledby="browseDropdown">
                    <a class="dropdown-item" href="{{ url('info/rules') }}">Rules & FAQ</a>
                    <a class="dropdown-item" href="{{ url('info/guide') }}">Guidebook</a>
                    <a class="dropdown-item" href="{{ url('world') }}">
                    Encyclopedia
                        </a>
                        <div class="dropdown-divider"></div> 
                        <a class="dropdown-item" href="{{ url('gallery') }}">Gallery</a>
                        <div class="dropdown-divider"></div> 
                        <a class="dropdown-item" href="{{ url('masterlist') }}">
                            Cossetling Masterlist
                        </a>
                        <a class="dropdown-item" href="{{ url('sublist/npc') }}">
                            NPC Masterlist
                        </a>
                        <a class="dropdown-item" href="{{ url('sublist/myo') }}">
                            MYO Masterlist
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('users') }}">
                            Users
                        </a>                        
                    </div>
                </li>
                <div class="dis2"><a href="https://discord.gg/YQqN7YqEGR"><img src="https://i.imgur.com/uWqtpz1.png" border="0" data-toggle="tooltip" title="Cossetlings Discord" class="dis" style="position: relative; z-index: 2; width: 18px; margin-left: 8px; margin-top: 12px;"></a></div>
                <li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link cc-1" style="color:#4A4A4A; font-size: 10pt;" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link cc-1" style="color:#4A4A4A; font-size: 10pt;" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->isStaff)
                        <li class="nav-item d-flex">
                            <a class="nav-link cc-2 position-relative display-inline-block"  style="color: #E5C1C7;" href="{{ url('admin') }}"><i class="fas fa-crown"></i>
                              @if (Auth::user()->hasAdminNotification(Auth::user()))
                                <span class="position-absolute text-dark aca" style="background-color: #EDD3A0; border-radius: 999px; height: auto; top: -2px; right: -5px; padding: 1px 6px 1px 6px; font-weight:bold; font-size: 0.8em;">
                                  {{ Auth::user()->hasAdminNotification(Auth::user()) }}
                                </span>
                              @endif
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->notifications_unread)
                        <li class="nav-item">
                            <a class="nav-link cc-5 btn btn-sm" style="background-color: #EDD3A0;" href="{{ url('notifications') }}"><span class="fas fa-envelope"></span> {{ Auth::user()->notifications_unread }}</a>
                        </li>
                    @endif

                    @foreach(Auth::user()->getCurrencies(true) as $currency)
                    <li class="nav-item" style="color: #4A4A4A; margin-top: 5px; margin-left: 2.5px; padding: 2.5px;"> {!! $currency->display($currency->quantity) !!} @break($currency->id > 0)</li>
            @endforeach
            <li class="nav-item mbg"><a role="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="fas fa-briefcase bb-5" data-toggle="tooltip" title="Check All Currencies" style="color: #95b582; margin-top: 9px; font-size: 13pt; margin-left: 2.5px; margin-right: 2.5px; padding: 2.5px; padding-left: 3px;"></span></a></li>
            <div class="collapse bb-6" id="collapseExample" style="height: inherit; position: absolute; z-index: 3; top: 100%; max-width: auto; background-color: #fafafa; margin: auto; padding: 10px; border-radius: 2.5px; font-family: Mali; text-transform: lowercase;">@foreach(Auth::user()->getCurrencies(true) as $currency)<span class="bb-6" style="color: #4A4A4A; margin-top: 5px; margin-left: 0.5px; padding: 2.5px;"> {!! $currency->display($currency->quantity) !!}</span>@endforeach</div>
            <li class="nav-item dropdown">
                        <a id="browseDropdown" class="nav-link dropdown-toggle cc-1" href="#" style="color:#4A4A4A; font-size: 10pt;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Submit
                        </a>

                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
                            <a class="dropdown-item" href="{{ url('submissions/new') }}">
                                Submit Prompt
                            </a>
                            <a class="dropdown-item" href="{{ url('claims/new') }}">
                                Submit Claim
                            </a>
                            <a class="dropdown-item" href="{{ url('reports/new') }}">
                                Submit Report
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle cc-1" style="color:#4A4A4A; font-size: 10pt;" href="{{ Auth::user()->url }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ Auth::user()->url }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ url('notifications') }}">
                                Notifications
                            </a>
                            <a class="dropdown-item" href="{{ url('account/bookmarks') }}">
                                Bookmarks
                            </a>
                            <a class="dropdown-item" href="{{ url('account/settings') }}">
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

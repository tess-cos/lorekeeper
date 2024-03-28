<nav class="navbar navbar-expand-md navbar-light">
    <ul class="navbar-nav ml-auto mr-auto ">
        <li class="nav-item"><a href="{{ url('info/about') }}" class="nav-link cc-1">About</a></li>
        <li class="nav-item"><a href="{{ url('info/terms') }}" class="nav-link cc-1">Terms</a></li>
        <li class="nav-item"><a href="{{ url('info/privacy') }}" class="nav-link cc-1">Privacy</a></li>
        <li class="nav-item"><a href="{{ url('reports/bug-reports') }}" class="nav-link cc-1">Bug Reports</a></li>
        <li class="nav-item"><a href="{{ url('credits') }}" class="nav-link cc-1">Credits</a></li>
    </ul>
</nav>
<div class="copyright">&copy; {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }} v{{ config('lorekeeper.settings.version') }} {{ Carbon\Carbon::now()->year }}</div>
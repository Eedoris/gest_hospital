@php
    use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @if (isset($submenu->roles) && in_array(Auth::user()->statut, $submenu->roles))
                @php
                    // Calculer si le sous-menu est actif
                    $activeClass = request()->is(ltrim($submenu->url ?? '', '/')) ? 'active' : '';
                @endphp

                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
                        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    </a>
                </li>
            @endif
        @endforeach
    @endif
</ul>

{{-- @php
    $filteredMenu = array_filter($menu, function ($submenu) {
        // Exemple de condition : afficher uniquement les menus visibles
        return isset($submenu->is_visible) && $submenu->is_visible;
    });
@endphp

<ul class="menu-sub">
    @if (isset($filteredMenu))
        @foreach ($filteredMenu as $submenu)
            {{-- active menu method
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Route::currentRouteName();

                if ($currentRouteName === $submenu->slug) {
                    $activeClass = 'active';
                } elseif (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (
                            str_contains($currentRouteName, $submenu->slug) &&
                            strpos($currentRouteName, $submenu->slug) === 0
                        ) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp

            <li class="menu-item {{ $activeClass }}">
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                    class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($submenu->target) && !empty($submenu->target)) target="_blank" @endif>
                    @if (isset($submenu->icon))
                        <i class="{{ $submenu->icon }}"></i>
                    @endif
                    <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    @isset($submenu->badge)
                        <div class="badge rounded-pill bg-{{ $submenu->badge[0] }} text-uppercase ms-auto">
                            {{ $submenu->badge[1] }}</div>
                    @endisset
                </a>

                {{-- submenu
                @if (isset($submenu->submenu))
                    @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul> --}}

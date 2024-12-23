<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <style>
        .menu .app-brand.demo {
            height: 100px;
            margin-top: 12px;
        }

        .app-brand-logo.demo svg {
            width: 200px;
            height: 180px;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
        }

        .logout-btn a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            text-decoration: none;
        }

        .logout-btn a:hover {
            background-color: #f8f9fa;
        }

        .logout-btn i {
            margin-right: 10px;
        }
    </style>

    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>


    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            {{-- Vérifier si l'utilisateur a accès à cet élément --}}
            @if (isset($menu->roles) && in_array(Auth::user()->statut, $menu->roles))
                <li class="menu-item {{ request()->is(ltrim($menu->url ?? '', '/')) ? 'active' : '' }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                    </a>

                    {{-- Sous-menu (si disponible) --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>
    <div class="logout-btn">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bx bx-log-out"></i> <span>Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>


</aside>

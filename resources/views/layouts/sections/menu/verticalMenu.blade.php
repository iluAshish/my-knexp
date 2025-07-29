@php
    $configData = Helper::appClasses();
    use App\Models\SiteInformation;
    $siteInformation = SiteInformation::where('deleted_at',NULL)->get()->first();
    $dashboard_logo = isset($siteInformation->dashboard_logo) ? $siteInformation->dashboard_logo : '' ;
@endphp
<style>
    .app-brand-logo.demo {
        width: 100%;
        height: 50px;
    }

    .app-brand-logo img {
        width: 100%;
        height: 100%;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                @if (isset($dashboard_logo))
                    <span class="app-brand-logo demo">
                    <img
                        src="{{ url('storage/site_information/dashboard_logo/') . '/' . $dashboard_logo }}"
                        alt="" srcset="">
                </span>
                @endif
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @php
            $filterMenu = [];
            foreach ($menuData[0]['menu'] as $menu) {
                if(isset($menu['slug'])) {
                    if(auth()->user()->hasPermissionTo($menu['slug']) || auth()->user()->hasDirectPermissionTo($menu['slug'])) {
                        $filterMenu[] = $menu;
                    }
                } else {
                    $filterMenu[] = $menu;
                }
            }
			$filterMenu = json_decode(json_encode($filterMenu));
        @endphp

{{--        @foreach ($menuData[0]->menu as $menu)--}}
        @foreach ($filterMenu as $index => $menu)

            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                @php
                    $showCMSHeading = false;
                    for ($i = $index + 1; $i < count($filterMenu); $i++) {
                        if (!isset($filterMenu[$i]->menuHeader)) {
                            $showCMSHeading = true;
                            break;
                        }
                    }
                @endphp
                @if ($showCMSHeading)
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                </li>
                @endif
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();

					if($currentRouteName == "date.list") {
						$currentRouteName = "datelockdate.list";
					} elseif($currentRouteName == "day.list") {
						$currentRouteName = "datelockweek.list";
					} elseif(isset($menu->submenu) && $currentRouteName == "role.index") {
						$currentRouteName = "";
                        $activeClass = 'active open';
					}

                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        } else {
                            if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                {{-- main menu --}}
                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                       class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                       @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        @isset($menu->badge)
                            <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>

</aside>

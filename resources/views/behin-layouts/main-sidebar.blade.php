<aside class="main-sidebar elevation-4">

    <!-- User Profile -->
    <div class="sidebar">
        <div style="direction: rtl;">
            <div class="user-panel d-flex align-items-center">
                <div class="info">
                    <span class="fw-bold">{{ auth()->user()->name ?? 'کاربر' }}</span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    @foreach (config('sidebar.menu') as $menu)
                        @if ( access('منو >>' .$menu['fa_name']) )
                            <li class="nav-item">
                                <a href="#" class="nav-link optic-nav-link">
                                    <i class="nav-icon fa fa-{{ $menu['icon'] }}"></i>
                                    <span>{{ $menu['fa_name'] }}</span>
                                    <i class="nav-arrow fa fa-angle-left left"></i>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach ($menu['submenu'] as $submenu)
                                        @if ( access('منو >>' .$menu['fa_name'] . '>>' . $submenu['fa_name'] ) )
                                            <li class="nav-item">
                                                <a 
                                                    @isset($submenu['target']) target="{{ $submenu['target'] }}" @endisset
                                                    href="@if(Route::has($submenu['route-name'])) 
                                                                {{ route($submenu['route-name']) }} 
                                                            @elseif(isset($submenu['static-url']))
                                                                {{ $submenu['static-url'] }}
                                                            @else
                                                                {{ url($submenu['route-url']) }} 
                                                            @endif"
                                                    class="nav-link" 
                                                    >
                                                    
                                                    <i class="nav-icon fa fa-circle"></i>
                                                    <span>{{ $submenu['fa_name'] }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</aside>

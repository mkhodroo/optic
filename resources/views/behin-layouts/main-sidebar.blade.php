<aside class="main-sidebar elevation-4" style="background: #263238; color: #fff; min-height: 100vh;">

    <!-- User Profile -->
    <div class="sidebar p-3" style="direction: ltr;">
        <div style="direction: rtl;">
            <div class="user-panel d-flex align-items-center mb-4 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                <div class="image me-2">
                    <img src="{{ url('public/behin/behin-dist/dist/img/avatar5.png') }}"
                         class="rounded-circle" alt="User Image" width="45" height="45">
                </div>
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
                                <a href="#" class="nav-link d-flex align-items-center" style="color: #fff; padding: 10px 15px;">
                                    
                                    <span>{{ $menu['fa_name'] }}</span>
                                    
                                </a>
                                <ul class="nav nav-treeview ms-3" style="border-left: 2px solid rgba(255,255,255,0.1); margin-left: 10px;">
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
                                                    style="color: #cfd8dc; padding: 8px 15px; transition: all 0.3s ease;">
                                                    
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

<!-- Material Icons -->
{{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}

<style>
    .nav-link {
        color: #bfbfbf !important;
        border-radius: 8px;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.08);
        color: #fff !important;
        border-radius: 8px;
    }
    .nav-treeview .nav-link:hover {
        background: rgba(255,255,255,0.05);
        padding-left: 20px !important;
    }
</style>

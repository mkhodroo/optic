<?php
use App\CustomClasses\Access;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand">
    <ul class="navbar-nav optic-header-start align-items-center">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <li class="nav-item optic-brand d-none d-md-flex">
            <span class="optic-brand-mark"><i class="fa fa-layer-group"></i></span>
            <span>پنل مدیریت</span>
        </li>
        <li class="nav-item optic-header-divider d-none d-lg-block"></li>
        @if (access('send-sms'))
            <li class="nav-item d-none d-lg-block">
                <a href="{{ url('admin/send-sms') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-paper-plane"></i> ارسال پیامک
                </a>
            </li>
        @endif
        <li class="nav-item d-none d-xl-block">
            <a href="{{ route('send-notification') }}" class="btn btn-sm btn-light text-warning" title="تست نوتیفیکیشن">
                <i class="fa fa-bell"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav optic-header-actions align-items-center">
        <li class="nav-item">
            <button type="button" class="btn btn-sm btn-light" onclick="window.location.reload()" ondblclick="{{ url('build-app') }}" title="بارگذاری مجدد">
                <i class="fa fa-refresh"></i><span class="ms-1"></span>
            </button>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin') }}" class="btn btn-sm btn-primary" title="صفحه اصلی"><i class="fa fa-home text-white"></i></a>
        </li>
        @include('TodoListViews::partial-views.todo-list-icon')
        @include('UserProfileViews::partial-views.user-profile-icon')
        <li class="nav-item">
            <button class="btn btn-sm btn-danger" onclick="logout()" title="خروج"><i class="fa fa-sign-out text-white"></i></button>
        </li>
    </ul>
</nav>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('behin/logo.ico') . '?' . config('app.version') }}">
    <link rel="manifest" href="{{ url('manifest.json') . '?' . config('app.version') }}">

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/font-awesome/css/font-awesome.min.css') . '?' . config('app.version') }}">
    
    <!-- Theme style -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/dist/css/adminlte.min.css') . '?' . config('app.version') }}">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/datepicker/datepicker3.css') . '?' . config('app.version') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/daterangepicker/daterangepicker-bs3.css') . '?' . config('app.version') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') . '?' . config('app.version') }}">
    
    <!-- bootstrap rtl -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/dist/css/bootstrap-rtl.min.css') . '?' . config('app.version') }}">
    <!-- template rtl version -->
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/dist/css/custom-style.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/dist/css/custom.css') . '?' . config('app.version') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ url('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.css') . '?' . config('app.version') }}" />
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/dist/css/dropzone.min.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/toastr/toastr.min.css') . '?' . config('app.version') }}">
    
    
    <link rel="stylesheet" href="{{ url('behin/behin-dist/plugins/select2/select2.min.css') }}">
    
    <link rel="stylesheet" href="{{ url('behin/behin-dist/persian-date-picker/persian-datepicker.css') }}">
    
    <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/mapp/css/mapp.min.css') . '?' . config('app.version') }}">
    
        <link rel="stylesheet"
        href="{{ url('behin/behin-dist/plugins/mapp/css/fa/style.css') . '?' . config('app.version') }}">
    
    
        {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css"> --}}
    
    
    <link rel="stylesheet" href="{{ url('behin/behin-dist/plugins/sweetalert/sweetalert2.min.css') }}">


    <!-- Modern dashboard theme -->
    <style>
        :root {
            --optic-primary: #2563eb;
            --optic-primary-dark: #1d4ed8;
            --optic-ink: #172033;
            --optic-muted: #718096;
            --optic-surface: #ffffff;
            --optic-bg: #f4f7fb;
            --optic-border: #e7edf5;
            --optic-sidebar-width: 272px;
        }

        * { box-sizing: border-box; }
        html, body { min-height: 100%; }
        body {
            background: var(--optic-bg);
            color: var(--optic-ink);
            font-family: 'Source Sans Pro', Tahoma, sans-serif;
            font-size: 15px;
        }
        .wrapper { min-height: 100vh; }
        .main-header.navbar {
            background: rgba(255,255,255,.98) !important;
            border: 0;
            box-shadow: 0 4px 20px rgba(25, 45, 80, .06);
            min-height: 52px;
            padding: 0 24px;
            
            left: 0;
            width: auto;
            z-index: 1035;
        }
        .main-header.navbar > .navbar-nav { flex-direction: row; }
        .main-header .optic-header-start { margin-right: 0; margin-left: auto; }
        .main-header .optic-header-actions { margin-right: auto; margin-left: 0; gap: 8px; }
        .main-header .optic-header-actions > .nav-item { margin: 0 !important; }
        .main-header .nav-link, .main-header .nav-item > .btn {
            color: var(--optic-muted) !important;
        }
        .main-header .nav-link {
            width: 42px; height: 42px; border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: .2s ease;
        }
        .main-header .nav-link:hover { background: #eef4ff; color: var(--optic-primary) !important; }
        .main-header .btn { border: 0; box-shadow: none; border-radius: 11px; }
        .main-header .btn:hover { transform: none; box-shadow: none; background: #eef4ff; color: var(--optic-primary) !important; }
        .optic-brand { display:flex; align-items:center; gap:11px; margin-right: 28px; color: var(--optic-ink); font-weight: 700; font-size: 18px; white-space: nowrap; }
        .optic-brand-mark { width: 38px; height: 38px; display:inline-flex; align-items:center; justify-content:center; border-radius: 12px; color:#fff; background: linear-gradient(135deg,#2563eb,#60a5fa); box-shadow: 0 7px 16px rgba(37,99,235,.25); }
        .optic-header-divider { width: 1px; height: 28px; background: var(--optic-border); margin: 0 8px; }
        .main-sidebar {
            background: var(--optic-surface) !important;
            border: 0; border-left: 0; box-shadow: -4px 0 24px rgba(25,45,80,.055);
            width: var(--optic-sidebar-width); height: 100vh; min-height: 100vh;
            top: 0; bottom: 0; right: 0; left: auto; position: fixed;
            overflow: hidden; z-index: 1040;
        }
        .main-sidebar .sidebar { height: 100%; padding: 24px 16px !important; direction: rtl !important; overflow-y: auto; }
        .main-sidebar .user-panel { background: #f6f8fc !important; border: 1px solid var(--optic-border); border-radius: 16px; padding: 14px !important; margin-bottom: 25px !important; }
        .main-sidebar .user-panel img { width: 44px; height: 44px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 3px 10px rgba(25,45,80,.12); }
        .main-sidebar .user-panel .info { color: var(--optic-ink); line-height: 1.4; }
        .main-sidebar .user-panel .info:before, .main-sidebar .user-panel .info:after { display:none; }
        .main-sidebar .user-panel .image { width: 48px; flex: 0 0 48px; }
        .nav-sidebar .nav-item > .optic-nav-link { display: flex; align-items: center; color: #66758a !important; border-radius: 11px; margin: 3px 0; padding: 12px 14px !important; font-weight: 600; transition: .2s ease; }
        .nav-sidebar .optic-nav-link .nav-icon { width: 28px; flex: 0 0 28px; margin: 0 8px 0 0; text-align: right; font-size: 16px; color: #8fa0b5; }
        .nav-sidebar .optic-nav-link .nav-arrow { margin-right: auto; margin-left: 0; font-size: 13px; color: #a5b0bf; transition: transform .2s ease; }
        .nav-sidebar .menu-open > .optic-nav-link, .nav-sidebar .optic-nav-link:hover, .nav-sidebar .optic-nav-link.active { color: var(--optic-primary) !important; background: #eff5ff; }
        .nav-sidebar .menu-open > .optic-nav-link .nav-icon, .nav-sidebar .optic-nav-link:hover .nav-icon { color: var(--optic-primary); }
        .nav-sidebar .menu-open > .optic-nav-link .nav-arrow { transform: rotate(-90deg); }
        .nav-sidebar .nav-treeview { border-right: 1px solid #e8eef7 !important; margin: 3px 28px 8px 0 !important; padding-right: 8px !important; }
        .nav-sidebar .nav-treeview .nav-link { display: flex; align-items: center; color: #8a98aa !important; border-radius: 9px; padding: 9px 12px !important; font-size: 14px; }
        .nav-sidebar .nav-treeview .nav-link .nav-icon { width: 20px; margin: 0 8px 0 0; color: #b3becb; font-size: 6px; }
        .nav-sidebar .nav-treeview .nav-link:hover, .nav-sidebar .nav-treeview .nav-link.active { color: var(--optic-primary) !important; background: #f1f6ff; }
        .content-wrapper { margin-right: var(--optic-sidebar-width); margin-left: 0; min-height: 100vh; background: var(--optic-bg); }
        .content-wrapper .content { padding: 28px 30px 36px; }
        .content-wrapper .container-fluid { max-width: 1600px; }
        .content-wrapper .container-fluid.p-2 { padding: 0 !important; margin-top: 0; }
        .card { border: 1px solid var(--optic-border); border-radius: 16px; box-shadow: 0 6px 24px rgba(25,45,80,.045); margin-bottom: 22px; }
        .card-header { background: transparent; border-bottom: 1px solid var(--optic-border); padding: 15px 20px; }
        .btn { border-radius: 10px; box-shadow: none; transition: .2s ease; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 5px 12px rgba(25,45,80,.08); }
        .btn-primary { background: var(--optic-primary); border-color: var(--optic-primary); }
        .btn-outline-primary { color: var(--optic-primary); border-color: #b9d0ff; }
        .btn-outline-primary:hover { background: var(--optic-primary); border-color: var(--optic-primary); }
        .alert { border: 0; border-radius: 12px; }
        table.dataTable { border: 1px solid var(--optic-border); border-radius: 12px; overflow: hidden; }
        table.dataTable thead { background: #f7f9fc; color: #607087; }
        .select2-container .select2-selection--single { height: 40px !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 40px !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px !important; }
        .main-footer { background: transparent; border: 0; padding: 15px 30px 22px; color: #9aa6b5; }
        @media (max-width: 991px) {
            .main-sidebar { width: 272px; transform: translateX(100%); transition: transform .3s ease; }
            .content-wrapper, .main-footer, .main-header.navbar { margin-right: 0 !important; }
            .main-header.navbar { right: 0; padding: 0 14px; }
            .sidebar-open .main-sidebar { transform: translateX(0); }
            .optic-header-divider, .optic-brand span { display:none; }
            .optic-brand { margin-left: 8px; }
            .content-wrapper .content { padding: 20px 15px 30px; }
        }
        @media (min-width: 992px) {
            
            .sidebar-collapse .content-wrapper { margin-right: var(--optic-sidebar-width) !important; }
            .sidebar-collapse .main-sidebar { transform: none; }
        }
        @media (max-width: 575px) { .main-header .btn span { display:none; } .main-header .btn { padding: .45rem .65rem; } .main-header { padding: 0 8px !important; } .optic-header-actions { gap: 3px; } }
    </style>
    @yield('style')

    <script src="{{ url('behin/behin-dist/plugins/jquery/jquery.min.js') . '?' . config('app.version') }}"></script>
    <script
        src="{{ url('behin/behin-dist/plugins/datatables/jquery.dataTables.js') . '?' . config('app.version') }}">
    </script>
    <script
        src="{{ url('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.js') . '?' . config('app.version') }}">
    </script>
    <script src="{{ url('behin/behin-dist/persian-date-picker/persian-date.js') . '?' . config('app.version') }}">
    </script>
    <script
        src="{{ url('behin/behin-dist/persian-date-picker/persian-datepicker.js') . '?' . config('app.version') }}">
    </script>


    <script src="{{ url('behin/behin-dist/plugins/mapp/js/mapp.env.js') . '?' . config('app.version') }}"></script>

    <script>
        window.appUrl = "{{ env('APP_URL') }}";
    </script>
    <script src="{{ url('behin/behin-js/ajax.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('behin/behin-js/dataTable.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('behin/behin-js/dropzone.js') . '?' . config('app.version') }}"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> --}}
    <script
        src="{{ url('behin/behin-dist/plugins/autonumeric/autoNumeric.min.js') . '?' . config('app.version') }}">
    </script>

    {{-- ACE Editor --}}
    <script src={{ url('behin/behin-dist/plugins/ace/1.13.1/ace.js') }}></script>
    <script src={{ url('behin/behin-dist/plugins/ace/1.13.1/mode-php.js') }}></script>
    <script src={{ url('behin/behin-dist/plugins/ace/1.13.1/theme-monokai.js') }}></script>
    <script src={{ url('behin/behin-dist/plugins/ace/1.13.1/ext-language_tools.min.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



    @yield('script_in_head')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('behin-layouts.header')

        @include('behin-layouts.main-sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if (!isset($disableBackBtn))
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ isset($backUrl) ? $backUrl : 'javascript:history.back()' }}"
                                    class="btn btn-outline-primary float-left">
                                    <i class="fa fa-arrow-left"></i> {{ trans('fields.Back') }}
                                </a>
                            </div>
                        </div>
                    @endisset
                    @if (!isset($disableSessionMsg))
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
            </div>
            <div class="container-fluid p-2">
                @yield('content')
            </div>
        </section>
    </div>



    <footer class="main-footer">
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

<script
    src="{{ url('behin/behin-dist/plugins/bootstrap/js/bootstrap.bundle.min.js') . '?' . config('app.version') }}">
</script>
<script src="{{ url('behin/behin-dist/plugins/knob/jquery.knob.js') . '?' . config('app.version') }}"></script>
<script
    src="{{ url('behin/behin-dist/plugins/daterangepicker/daterangepicker.js') . '?' . config('app.version') }}">
</script>
<script
    src="{{ url('behin/behin-dist/plugins/datepicker/bootstrap-datepicker.js') . '?' . config('app.version') }}">
</script>
<script
    src="{{ url('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') . '?' . config('app.version') }}">
</script>
<script src="{{ url('behin/behin-dist/dist/js/adminlte.js') . '?' . config('app.version') }}"></script>
<script src="{{ url('behin/behin-dist/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ url('behin/behin-dist/plugins/mapp/js/mapp.min.js') . '?' . config('app.version') }}"></script>
<script src="{{ url('behin/behin-dist/plugins/toastr/toastr.min.js') . '?' . config('app.version') }}"></script>
<script src="{{ url('behin/behin-dist/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>

{{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: "{{ config('broadcasting.pusher.instanceId') }}",
        });
        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
            url: "{{ url('/pusher/beams-auth') }}"
        });

        beamsClient.getUserId()
            .then(userId => {
                if (!userId) {
                    beamsClient.start().then(() => {
                        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
                            url: "{{ url('/pusher/beams-auth') }}"
                        });
                        beamsClient.setUserId(
                            "{{ config('broadcasting.pusher.prefix_user') }}{{ Auth::id() }}",
                            beamsTokenProvider)
                    })
                } else {
                    console.log('User ID:', userId);
                }
            })
            .catch(console.error);
    </script>
    <script>
        function checkNotificationPermission() {
            if (!('Notification' in window)) {
                alert('این مرورگر از نوتیفیکیشن پشتیبانی نمی‌کند.');
                return;
            }

            if (Notification.permission === 'granted') {
                new Notification('نوتیفیکیشن فعال است', {
                    body: 'شما قبلاً مجوز داده‌اید!',
                    icon: '{{ url('behin/logo.ico') }}'
                });
            } else if (Notification.permission === 'denied') {
                alert('شما مجوز نوتیفیکیشن را رد کرده‌اید. لطفاً از تنظیمات مرورگر آن را فعال کنید.');
            } else {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        new Notification('متشکریم!', {
                            body: 'شما نوتیفیکیشن را فعال کردید.'
                        });
                    }
                });
            }
        }
    </script> --}}
<script>
    function logout() {
        // beamsClient.stop().catch(console.error);
        window.location = "{{ route('logout') }}"
    }
</script>



<script>
    initial_view()

    function initial_view() {
        $('.select2').select2();
        $('.select2').css('width', '100%')
        $(".persian-date").persianDatepicker({
            viewMode: 'day',
            initialValue: false,
            format: 'YYYY-MM-DD',
            initialValueType: 'persian',
            calendar: {
                persian: {
                    leapYearMode: 'astronomical',
                    locale: 'fa'
                }
            }
        });
        // $('.timepicker').timepicker({
        //     timeFormat: 'HH:mm', // فرمت 24 ساعته
        //     interval: 1, // نمایش با فاصله 5 دقیقه‌ای
        //     minTime: '00:00',
        //     maxTime: '23:55',
        //     dynamic: true,
        //     dropdown: true,
        //     scrollbar: true
        // });
        AutoNumeric.multiple('.formatted-digit', {
            digitGroupSeparator: ',',
            decimalCharacter: '.',
            decimalPlaces: 0,
            unformatOnSubmit: true
        });

        // $('table tbody td').each(function() {
        //     let $cell = $(this);
        //     let originalHtml = $cell.html();
        //     console.log(originalHtml)
        //     let textOnly = $cell.text().trim();

        //     // اگر شامل دکمه یا اسپن بود، هیچی تغییر نده
        //     if (originalHtml.includes('button') || originalHtml.includes('span') || originalHtml.includes('a')) {
        //         return;
        //     }

        //     if (textOnly.length > 25) {
        //         let shortText = textOnly.substr(0, 25) ;

        //         $cell.html(`
        //     <span class="short-text">${shortText}</span>
        //     <span class="full-text" style="display:none;">${originalHtml}</span>
        //     <button class="toggle-btn show-more-btn material-icons" style="border:none;background:none;cursor:pointer;">more_horiz</button>
        // `);
        //     }
        // });

        // // هندل کلیک روی نمایش بیشتر/کمتر
        // $(document).on('click', '.toggle-btn', function() {
        //     let $cell = $(this).closest('td');
        //     $cell.find('.short-text, .full-text').toggle();
        //     $(this).text($(this).text() === 'more_horiz' ? 'expand_less' : 'more_horiz');
        // });


    }
</script>

<script src="{{ url('behin/behin-js/loader.js') . '?' . config('app.version') }}"></script>
<script src="{{ url('behin/behin-js/scripts.js') . '?' . config('app.version') }}"></script>
@yield('script')
</div>


</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/images/Streamline.jpg') }}" rel="icon">
    <title>{{ config('app.name', 'Streamline') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    {{-- <link href="public/css/app.css" rel="stylesheet"> --}}
    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            jsPermissions: {!! auth()->check()?auth()->user()->jsPermissions():0 !!}
        }
    </script>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
                <img src="/images/Streamline.jpg" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">SimpleChat</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/images/default_image.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info" >
                        <span class="font-weight-bold" style="color:rgb(202, 202, 202)">{{ strtoupper(Auth::user()->name) }}</span> <br>
                        {{-- <span  style="color:#595959"><small>{{ strtoupper(Auth::user()->getRoleNames()) }}</small></span> --}}
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/Chat" class="nav-link">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>Chat</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/Server" class="nav-link">
                                <i class="nav-icon fas fa-server"></i>
                                <p>
                                    Server
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/groupchat" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Group Chat
                                </p>
                            </router-link>
                        </li>
                        {{-- @can('access user') --}}
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                        Users
                                    </p>
                                </router-link>
                            </li>
                        {{-- @endcan --}}
                        @can('access permission')
                            <li class="nav-item">
                                <router-link to="/permission" class="nav-link">
                                    <i class="nav-icon fas fa-user-lock"></i>
                                    <p>
                                        Permission
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access role')
                            <li class="nav-item">
                                <router-link to="/role" class="nav-link">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        Role
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access registrar')
                            <li class="nav-item">
                                <router-link to="/registrar" class="nav-link">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        Registrar
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        @can('access program')
                            <li class="nav-item">
                                <router-link to="/program" class="nav-link">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        Program
                                    </p>
                                </router-link>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            {{-- content vue here --}}
            <router-view></router-view>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="#">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    @auth
        <script>
            window.user = @json(auth()->user());
            window.role = @json(auth()->user()->role);
        </script>
    @endauth
    {{-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script> --}}
    <script src="{{ asset('/js/app.js') }}"></script>
    {{-- <script>
        window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
        ]) !!};
    </script> --}}

</body>
</html>

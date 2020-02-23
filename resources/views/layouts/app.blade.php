<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My Profile</a>
                            </li>
                            @can('manage-students')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Students
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('admin.students.index')}}">Student List</a>
                                    <a class="dropdown-item" href="{{route('admin.assignments.index')}}">Student Assignment</a>
                                    <a class="dropdown-item" href="#">Student Packages</a>
                                    <a class="dropdown-item" href="#">Packages</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-tutors')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tutors
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Tutors List</a>
                                    <a class="dropdown-item" href="#">Sessions</a>
                                    <a class="dropdown-item" href="#">Tutor Assignment</a>
                                    <a class="dropdown-item" href="#">Homework Assignments</a>
                                    <a class="dropdown-item" href="#">Rejected Tutors</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-payments')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Payments
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Billing Process</a>
                                    <a class="dropdown-item" href="#">Student Invoices</a>
                                    <a class="dropdown-item" href="#">Tutors Paycheques</a>
                                    <a class="dropdown-item" href="#">Payment Received</a>
                                    <a class="dropdown-item" href="#">Monthly Expenses</a>
                                    <a class="dropdown-item" href="#">Other Income</a>
                                    <a class="dropdown-item" href="#">CSV Upload</a>
                                    <a class="dropdown-item" href="#">Base Invoice Rates</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-payment-records')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Payment Records</a>
                            </li>
                            @endcan
                            @can('manage-tutor-students')
                            <li class="nav-item">
                                <a class="nav-link" href="#">List Students</a>
                            </li>
                            @endcan
                            @can('manage-student-tutors')
                            <li class="nav-item">
                                <a class="nav-link" href="#">My Tutors</a>
                            </li>
                            @endcan
                            @can('manage-invoices')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Invoices</a>
                            </li>
                            @endcan
                            @can('manage-add-student')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Add Student</a>
                            </li>
                            @endcan
                            @can('manage-cms')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    CMS
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Information</a>
                                    <a class="dropdown-item" href="#">Coupons</a>
                                    <a class="dropdown-item" href="#">Email Templates</a>
                                    <a class="dropdown-item" href="#">Mail Log</a>
                                    <a class="dropdown-item" href="#">Activity Log</a>
                                    <a class="dropdown-item" href="#">Send Email</a>
                                    <a class="dropdown-item" href="#">Send Notification</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-essay')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Essays</a>
                            </li>
                            @endcan
                            @can('manage-reports')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Reports
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Report Cards</a>
                                    <a class="dropdown-item" href="#">View Monthly Data</a>
                                    <a class="dropdown-item" href="#">Email Templates</a>
                                    <a class="dropdown-item" href="#">Tutor Report</a>
                                    <a class="dropdown-item" href="#">Student Report</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-sessions')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sessions</a>
                            </li>
                            @endcan
                            @can('manage-system')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    System
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Settings</a>
                                    <a class="dropdown-item" href="#">Users</a>
                                    <a class="dropdown-item" href="#">Countries</a>
                                    <a class="dropdown-item" href="#">Province / State</a>
                                    <a class="dropdown-item" href="#">Subjects</a>
                                    <a class="dropdown-item" href="#">Grades</a>
                                    <a class="dropdown-item" href="#">Error Logs</a>
                                    <a class="dropdown-item" href="#">Backup / Restore</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-discount-package')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Buy Discount Package</a>
                            </li>
                            @endcan
                            @can('manage-report-cards')
                            <li class="nav-item">
                                <a class="nav-link" href="#">Report Cards</a>
                            </li>
                            @endcan
                            @can('manage-tutoring-resource')
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="http://learnon.ca/tutor-help-center/">Tutoring Resources</a>
                            </li>
                            @endcan
                                <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->fname . Auth::user()->lname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    @can('manage-users')
                                    <a class="dropdown-item" href="{{route('admin.users.index')}}">
                                        User Management
                                    </a>
                                    @endcan

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

        <main class="py-4">
            <div class="container">
            @include('partials.alerts')
            @yield('content')
        </main>
    </div>
</body>
</html>

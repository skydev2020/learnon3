<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/images/favicon.png') }}" type="image/x-icon"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.13.1/standard-all/ckeditor.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" id = "title-bar">
            <div class="container" >
                <a class="navbar-brand" href="{{ url('/') }}" src = "{{ asset('/images/logo3.png') }}">
                    <img src = "{{ asset('/images/logo3.png') }}" alt = "Learnon" style = "width:97px; height:40px;">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @can('manage-users')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0 {{Request::segment(2) == 'home' ? 'active' : '' }}" href="{{route('admin.home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0 {{Request::segment(2) == 'myprofile' ? 'active' : '' }}" href="{{route('admin.myprofile.index')}}">My Profile</a>
                            </li>
                            @endcan
                            @can('manage-students')
                            <li class="nav-item dropdown">
                                <a class="tc-white nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["students", "assignments", "student_packages", "packages"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Students
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2)=="students" ? 'active' : '' }}" href="{{route('admin.students.index')}}">Student List</a>
                                    <a class="dropdown-item {{Request::segment(2)=="assignments" ? 'active' : '' }}" href="{{route('admin.assignments.index')}}">Student Assignment</a>
                                    <a class="dropdown-item {{Request::segment(2)=="student_packages" ? 'active' : '' }}" href="{{route('admin.student_packages.index')}}">Student Packages</a>
                                    <a class="dropdown-item {{Request::segment(2)=="packages" ? 'active' : '' }}" href="{{route('admin.packages.index')}}">Packages</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-tutors')
                            <li class="nav-item dropdown">
                                <a class="tc-white nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["tutors", "sessions", "tutorassignments"
                                , "essayassignments", "rejectedtutors"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tutors
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2)=="tutors" ? 'active' : '' }}" href="{{route('admin.tutors.index')}}">Tutors List</a>
                                    <a class="dropdown-item {{Request::segment(2)=="sessions" ? 'active' : '' }}" href="{{route('admin.sessions.index')}}">Sessions</a>
                                    <a class="dropdown-item {{Request::segment(2)=="tutorassignments" ? 'active' : '' }}" href="{{route('admin.tutorassignments.index')}}">Tutor Assignment</a>
                                    <a class="dropdown-item {{Request::segment(2)=="essayassignments" ? 'active' : '' }}" href="{{route('admin.essayassignments.index')}}">Homework Assignments</a>
                                    <a class="dropdown-item {{Request::segment(2)=="rejectedtutors" ? 'active' : '' }}" href="{{route('admin.rejectedtutors.index')}}">Rejected Tutors</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-payments')
                            <li class="nav-item dropdown">
                                <a class="tc-white nav-link nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["process", "invoices", "paycheques"
                                , "receivedpayments", "expenses", "otherincomes", "csvupload", "defaultwages"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Payments
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2)=="process" ? 'active' : '' }}"
                                     href="{{route('admin.process.index')}}">Billing Process</a>
                                    <a class="dropdown-item {{Request::segment(2)=="invoices" ? 'active' : '' }}"
                                    href="{{route('admin.invoices.index')}}">Student Invoices</a>
                                    <a class="dropdown-item {{Request::segment(2)=="paycheques" ? 'active' : '' }}"
                                     href="{{route('admin.paycheques.index')}}">Tutors Paycheques</a>
                                    <a class="dropdown-item {{Request::segment(2) == "receivedpayments" ? 'active' : ''}}"
                                     href="{{route('admin.receivedpayments.index')}}">Payment Received</a>
                                    <a class="dropdown-item {{Request::segment(2) == "expenses" ? 'active' : ''}}"
                                     href="{{route('admin.expenses.index')}}">Monthly Expenses</a>
                                    <a class="dropdown-item {{Request::segment(2) == "otherincomes" ? 'active' : ''}}"
                                     href="{{route('admin.otherincomes.create')}}">Other Income</a>
                                    <a class="dropdown-item {{Request::segment(2) == "csvupload" ? 'active' : ''}}"
                                     href="{{route('admin.csvupload.index')}}">CSV Upload</a>
                                    <a class="dropdown-item {{Request::segment(2) == "defaultwages" ? 'active' : ''}}"
                                     href="{{route('admin.defaultwages.index')}}">Base Invoice Rates</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-payment-records')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.myprofile.index')}}">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.paymentrecords.index')}}">Payment Records</a>
                            </li>
                            @endcan
                            @can('manage-tutor-students')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0 {{Request::is('home') ? 'active' : '' }}" href="{{route('home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.students.index')}}">List Students</a>
                            </li>
                            @endcan
                            @can('manage-student-tutors')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0 {{Request::is('home') ? 'active' : '' }}" href="{{route('home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.myprofile.index')}}">Account info</a>
                            </li>
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.tutors.index')}}">My Tutors</a>
                            </li>
                            @endcan
                            @can('manage-invoices')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.invoices.index')}}">Invoices</a>
                            </li>
                            @endcan
                            @can('manage-add-student')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.children.index')}}">Add Student</a>
                            </li>
                            @endcan
                            @can('manage-cms')
                            <li class="nav-item dropdown">
                                <a class="tc-white nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["informations", "coupons", "broadcasts"
                                , "maillogs", "activitylogs", "emailsend", "notification"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    CMS
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2) == "informations" ? 'active' : ''}}"
                                     href="{{route('admin.informations.index')}}">Information</a>
                                    <a class="dropdown-item {{Request::segment(2) == "coupons" ? 'active' : ''}}"
                                     href="{{route('admin.coupons.index')}}">Coupons</a>
                                    <a class="dropdown-item {{Request::segment(2) == "broadcasts" ? 'active' : ''}}"
                                     href="{{route('admin.broadcasts.index')}}">Email Templates</a>
                                    <a class="dropdown-item {{Request::segment(2) == "maillogs" ? 'active' : ''}}"
                                     href="{{route('admin.maillogs.index')}}">Mail Log</a>
                                    <a class="dropdown-item {{Request::segment(2) == "activitylogs" ? 'active' : ''}}"
                                     href="{{route('admin.activitylogs.index')}}">Activity Log</a>
                                    <a class="dropdown-item {{Request::segment(2) == "emailsend" ? 'active' : ''}}"
                                     href="{{route('admin.emailsend.index')}}">Send Email</a>
                                    <a class="dropdown-item {{Request::segment(2) == "notification" ? 'active' : ''}}"
                                     href="{{route('admin.notification.index')}}">Send Notification</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-essay')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.essays.index')}}">Essays</a>
                            </li>
                            @endcan
                            @can('manage-reports')
                            <li class="nav-item dropdown">
                                <a class="tc-white nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["progressreports", "monthlydata", "tutorreports"
                                , "studentreports"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Reports
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2) == 'progressreports' ? 'active' : ''}}"
                                     href="{{route('admin.progressreports.index')}}">Report Cards</a>
                                     <a class="dropdown-item {{Request::segment(2) == 'monthlydata' ? 'active' : ''}}"
                                     href="{{route('admin.monthlydata.index')}}">View Monthly Data</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'tutorreports' ? 'active' : ''}}"
                                     href="{{route('admin.tutorreports.index')}}">Tutor Report</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'studentreports' ? 'active' : ''}}"
                                     href="{{route('admin.studentreports.index')}}">Student Report</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-sessions')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.sessions.index')}}">My Sessions</a>
                            </li>
                            @endcan
                            @can('manage-system')
                            <li class="nav-item dropdown">
                                <a class="tc-white  nav-link pt-0 pb-0 {{in_array(Request::segment(2), ["settings", "users", "countries"
                                , "states", "subjects", "grades", "errorlogs"]) ? 'active' : '' }} dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    System
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{Request::segment(2) == 'settings' ? 'active' : ''}}"
                                     href="{{route('admin.settings.index')}}">Settings</a>
                                     <a class="dropdown-item {{Request::segment(2) == 'users' ? 'active' : ''}}"
                                     href="{{route('admin.users.index')}}">Users</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'countries' ? 'active' : ''}}"
                                     href="{{route('admin.countries.index')}}">Countries</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'states' ? 'active' : ''}}"
                                     href="{{route('admin.states.index')}}">Province / State</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'subjects' ? 'active' : ''}}"
                                     href="{{route('admin.subjects.index')}}">Subjects</a>
                                    <a class="dropdown-item {{Request::segment(2) == 'grades' ? 'active' : ''}}"
                                     href="{{route('admin.grades.index')}}">Grades</a>
                                     <a class="dropdown-item {{Request::segment(2) == 'errorlogs' ? 'active' : ''}}"
                                     href="{{route('admin.errorlogs.index')}}">Error Logs</a>
                                    <a class="dropdown-item" href="#">Backup / Restore</a>
                                </div>
                            </li>
                            @endcan
                            @can('manage-discount-package')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.packages.index')}}">Buy Discount Package</a>
                            </li>
                            @endcan
                            @can('manage-student-reports')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('student.progressreports.index')}}">Report Cards</a>
                            </li>
                            @endcan
                            @can('manage-report-cards')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('tutor.reportcards.index')}}">Report Cards</a>
                            </li>
                            @endcan
                            @can('manage-tutoring-resource')
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" target="_blank" href="http://learnon.ca/tutor-help-center/">Tutoring Resources</a>
                            </li>
                            @endcan
                                <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{route('admin.help.index')}}">Help</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{ route('register') }}">{{ __('Student Registration') }}</a>
                            </li>
                            @endif
                            @if (Route::has('register_tutor'))
                            <li class="nav-item">
                                <a class="tc-white nav-link pt-0 pb-0" href="{{ route('register_tutor') }}">{{ __('Tutor Registration') }}</a>
                            </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="tc-white nav-link dropdown-toggle pt-0 pb-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->fname . Auth::user()->lname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    {{-- @can('manage-users')
                                    <a class="dropdown-item" href="{{route('admin.users.index')}}">
                                        User Management
                                    </a>
                                    @endcan --}}

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
            @include('partials.alerts')
            @yield('content')
        </main>
    </div>
    @yield('jssection')
</body>
</html>

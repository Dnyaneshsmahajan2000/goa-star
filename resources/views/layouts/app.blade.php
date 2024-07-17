
<!doctype html>
<html lang="{{ @str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
    data-sidebar-size="{{ $sidebar ?? 'lg' }}" data-sidebar-image="none">

<head>
    <style>
        ul.ui-autocomplete {
            z-index: 1100;
        }

        td,
        th {
            padding: 2px !important;
        }
    </style>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kj-Plast') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ @asset('') }}assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="{{ @asset('') }}assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ @asset('') }}assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ @asset('') }}assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ @asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ @asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ @asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ @asset('') }}assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">



</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width  ">
                <div class="navbar-header py-0 ">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ @asset('') }}assets/images/logo-sm.png" alt=""
                                        height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ @asset('') }}assets/images/logo-dark.png" alt=""
                                        height="17">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ @asset('') }}assets/images/logo-sm.png" alt=""
                                        height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ @asset('') }}assets/images/logo-light.png" alt=""
                                        height="17">
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-md-block">
                            <div class="position-relative">
                                <input type="text" class="form-control bg-white border border-2 border-gray"
                                    placeholder="Search....." autocomplete="off" id="search-options" value="">
                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                    id="search-close-options"></span>
                            </div>

                        </form>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>





                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>



                        <div class="dropdown ms-sm-3 header-item ">
                            @if (Auth::guest())
                            @else
                                <button type="button" class="btn" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-flex align-items-center">
                                        {{-- <img class="rounded-circle header-profile-user"
                                            src="{{ @asset('') }}assets/images/users/avatar-1.jpg"
                                            alt="Header Avatar"> --}}
                                        <span class="text-start ms-xl-2">
                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                                {{ @ucwords(Auth::user()->name) }}
                                            </span>
                                            <span
                                                class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">-</span>
                                        </span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <h6 class="dropdown-header">Welcome {{ @ucwords(Auth::user()->name) }}!</h6>
                                    <a class="dropdown-item" href=" {{ route('company.edit') }}">
                                        <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle">Profile</span>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('auth.lock') }}">
                                        <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle">Lock screen</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class='dropdown-item'>
                                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                            <span class="align-middle">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->

        @include('layouts.menubar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid p-0">
                    <!-- start page title -->
                    <div class="page-title-box  py-1  mb-2 ">
                        <div class="row px-0 g-0">
                            <div class="col-5 col-md-6">

                                <span class="h5 mb-sm-0 ">
                                    {{ ucwords($title ?? '') }}


                                </span>
                            </div>

                            <div class="col-7 col-md-6 ">

                                <input type="text" id='main_date_picker'
                                    class="form-control float-end text-end form-control-sm col-1  border-0  ">



                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    @include('layouts.alert')


                    @yield('content')



                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
  @php
            Session::put('pin_url', url()->full());
                            @endphp
                         
                        </div>

                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Modal Heading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id='modalContent'>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->



        <!-- JAVASCRIPT -->
        <script src="{{ @asset('') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ @asset('') }}assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ @asset('') }}assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ @asset('') }}assets/libs/feather-icons/feather.min.js"></script>
        <script src="{{ @asset('') }}assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="{{ @asset('') }}assets/js/plugins.js"></script>

        <!-- apexcharts -->
        <script src="{{ @asset('') }}assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="{{ @asset('') }}assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="{{ @asset('') }}assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="{{ @asset('') }}assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <script src="{{ @asset('') }}assets/js/pages/dashboard-ecommerce.init.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

        <!-- App js -->
        <script src="{{ @asset('') }}assets/js/app.js"></script>
        <script>
            $(document).ready(function() {
                new DataTable('#datatable');
            });
        </script>
       <script>
            var hiddenTime;
            var elapsedTime = 0;
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'hidden') {
                    hiddenTime = Date.now();
                    var redirectTimeout = setTimeout(function() {
                        window.location.href = '{{ route('auth.lock') }}';
                    }, 300000);

                } else {
                    if (hiddenTime && Date.now() - hiddenTime < 300000) {
                        clearTimeout(redirectTimeout);
                    }
                }
            });
        </script>
        <script>
            $('#main_date_picker').daterangepicker({
                @if (isset($date_type) && $date_type == 1)
                    singleDatePicker: true,
                    @php
                        $from_date = $to_date = date('d/m/Y', strtotime(session('date')));
                    @endphp
                @else
                    @php
                        $date_type = 2;
                        $from_date = date('d/m/Y', strtotime(session('from_date')));
                        $to_date = date('d/m/Y', strtotime(session('to_date')));
                    @endphp

                    ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                                .endOf(
                                    'month')
                            ]
                        },
                @endif


                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                },
                alwaysShowCalendars: true,
                autoApply: true,
                startDate: '{{ $from_date }}',
                endDate: '{{ $to_date }}',

            }, function(start, end, label) {
                var from_date = start.format('YYYY-MM-DD');
                var to_date = end.format('YYYY-MM-DD');
                $.ajax({
                    url: '{{ route('date.change') }}',
                    method: 'get',
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        date_type: {{ $date_type }}
                    },
                    success: function(response) {
                        // Refresh page on success
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(error);
                    }
                });

            });
        </script>
        <script>
            $(document).ready(function() {
                $("button[data-route]").click(function() {

                    var route = $(this).data("route"); // Constructing the full route

                    $.ajax({
                        url: route,
                        type: "GET",
                        success: function(data) {
                            $("#modalContent").html(data);
                        },
                        error: function(e) {
                            $("#modalContent").html(e);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var rows = $(".scrollable").find("tbody tr");
                var selectedRow = 0;
                var isTableFocused = true;

                // Function to set focus on the table rows
                function setRowFocus(row) {
                    $(rows).removeClass("bg-soft-primary");
                    $(row).addClass("bg-soft-primary");
                    selectedRow = $(rows).index(row);
                }

                // Function to handle keydown events
                $(document.body).on("keydown", function(e) {
                    if (!isTableFocused) return;

                    e.preventDefault();

                    $(rows[selectedRow]).removeClass("bg-soft-primary");

                    if (e.keyCode == 38) {
                        selectedRow--;
                    } else if (e.keyCode == 40) {
                        selectedRow++;
                    }

                    if (selectedRow >= rows.length) {
                        selectedRow = 0;
                    } else if (selectedRow < 0) {
                        selectedRow = rows.length - 1;
                    }

                    setRowFocus(rows[selectedRow]);
                });

                // Set the first row to selected color
                setRowFocus(rows[selectedRow]);

                // Open href of selected row on Enter key press
                $(document).on("keydown", function(event) {
                    if (!isTableFocused) return;

                    if (event.key === "Enter") {
                        var selectedHref = $(rows[selectedRow]).data("enter");
                        if (selectedHref) {
                            window.location = selectedHref;
                        }
                    } else if (event.key === "Delete") {
                        var selectedHref = $(rows[selectedRow]).data("delete");
                        if (selectedHref) {
                            window.location = selectedHref;
                        }
                    }
                });

                // Handle double click event on rows
                rows.on("dblclick", function() {
                    var selectedHref = $(this).data("enter");
                    if (selectedHref) {
                        window.location = selectedHref;
                    }
                });

                // Handle click event on rows to set focus
                rows.on("click", function() {
                    isTableFocused = true;
                    setRowFocus(this);
                });

                // Handle click event on document to unset table focus
                $(document).on("click", function(event) {
                    if (!$(event.target).closest(".scrollable").length) {
                        isTableFocused = false;
                        $(rows).removeClass("bg-soft-primary");
                    }
                });
            });
            // Call the function with the table element having the specified class
            // enableRowNavigation($(".scrollable"));
        </script>



</body>


</html>

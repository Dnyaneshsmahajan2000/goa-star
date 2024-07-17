@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu ">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href='{{ route('home') }}' class='logo logo-light'>
            <span class='logo-sm'>
                <img src='assets/images/logo-sm.png' alt='' height='22'>
            </span>
            {{--     <span class='logo-lg p'>
                        <!-- <img style = 'height:60px;' src = 'assets/images/logo-dark.png' alt = '' height = '37'> -->
                        <h3 class='text-white fw-bold mt-4 border border-3 px-4 py-1 border-white rounded-pill'>KJ-Plast
                        </h3>
                    </span> --}}
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <!-- Home Menu -->
                @if (isset($access['Home']) && is_array($access['Home']))
                    @php $homeAccess = $access['Home']; @endphp
                    @if ($homeAccess['add'] == '1')
                        <li class='nav-item'>
                            <a id='menu-home' class='nav-link menu-link' href='{{ route('home') }}'>
                                <i class='ri-home-fill'></i> <span data-key='t-authentication'>Home</span>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- Masters Menu -->
                @if (
                    (isset($access['Groups']) && $access['Groups']['add'] == '1') ||
                        (isset($access['Ledgers']) && $access['Ledgers']['add'] == '1') ||
                        (isset($access['Godown']) && $access['Godown']['add'] == '1') ||
                        (isset($access['Machines']) && $access['Machines']['add'] == '1'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i class='ri-team-fill'></i> <span data-key="t-apps">Masters</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">
                                @if (isset($access['Groups']) && $access['Groups']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('group.index') }}" class="nav-link"
                                            data-key="t-calendar">Groups</a>
                                    </li>
                                @endif
                                @if (isset($access['Ledgers']) && $access['Ledgers']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('ledger.index') }}" class="nav-link"
                                            data-key="t-chat">Ledgers</a>
                                    </li>
                                @endif
                                @if (isset($access['Godown']) && $access['Godown']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('godown.index') }}" class="nav-link"
                                            data-key="t-chat">Godowns</a>
                                    </li>
                                @endif
                                @if (isset($access['Machines']) && $access['Machines']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('machine.index') }}" class="nav-link"
                                            data-key="t-chat">Machines</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                <!-- Items Menu -->
                @if (
                    (isset($access['Item_Groups']) && $access['Item_Groups']['add'] == '1') ||
                        (isset($access['Item_Category']) && $access['Item_Category']['add'] == '1') ||
                        (isset($access['Items(Finish Good/Raw Material)']) && $access['Items(Finish Good/Raw Material)']['add'] == '1'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarEcommerce">
                            <i class="ri-apps-2-line"></i> <span data-key="t-apps">Items</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarEcommerce">
                            <ul class="nav nav-sm flex-column">
                                @if (isset($access['Item_Groups']) && $access['Item_Groups']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('item_group.create') }}" class="nav-link"
                                            data-key="t-products">Item Groups</a>
                                    </li>
                                @endif
                                @if (isset($access['Item_Category']) && $access['Item_Category']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('item.category.create') }}" class="nav-link"
                                            data-key="t-product-Details">Item Categories</a>
                                    </li>
                                @endif
                                @if (isset($access['Items(Finish Good/Raw Material)']) && $access['Items(Finish Good/Raw Material)']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('item.create') }}" class="nav-link" data-key="t-orders">Items
                                            (Finish Good - Raw Material)</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (isset($access['Manufacturing']) && $access['Manufacturing']['add'] == '1')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('vchmfg/create') }}">
                            <i class='bx bx-chair'></i> <span data-key="t-dashboards">Manufacturing</span>
                        </a>
                    </li>
                @endif
                @if (
                    (isset($access['Employee']) && $access['Employee']['add'] == '1') ||
                        (isset($access['Employee_Attendance']) && $access['Employee_Attendance']['add'] == '1') ||
                        (isset($access['Employee_Expenses']) && $access['Employee_Expenses']['add'] == '1') ||
                        (isset($access['Generate_Employee_Salary']) && $access['Generate_Employee_Salary']['add'] == '1'))

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayouts2" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarLayouts2">
                            <i class='ri-user-3-fill'></i> <span data-key="t-layouts">Payroll</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts2">
                            <ul class="nav nav-sm flex-column">
                                @if (isset($access['Employee']) && $access['Employee']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('user.create') }}" class="nav-link"
                                            data-key="t-two-column">Employee</a>
                                    </li>
                                @endif
                                @if (isset($access['Employee_Expenses']) && $access['Employee_Expenses']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('emp-expenses.create') }}" class="nav-link"
                                            data-key="t-two-column">Employee Expenses</a>
                                    </li>
                                @endif
                                @if (isset($access['Employee_Attendance']) && $access['Employee_Attendance']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('user.emp-attendance') }}" class="nav-link"
                                            data-key="t-two-column">Employee Attendance</a>
                                    </li>
                                @endif
                                @if (auth()->user()->role->name == 'Admin')
                                    <li class="nav-item">
                                        <a href="{{ route('Employee_Expenses.verify_expense') }}" class="nav-link"
                                            data-key="t-two-column">Verify Employee Expense</a>
                                    </li>
                                @endif
                                @if (isset($access['Generate_Employee_Salary']) && $access['Generate_Employee_Salary']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('user.generate_salary') }}" class="nav-link"
                                            data-key="t-two-column">Generate Employee Salary</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                <!-- Vouchers Menu -->
                @if (
                    (isset($access['Order']) && $access['Order']['add'] == '1') ||
                        (isset($access['Sale']) && $access['Sale']['add'] == '1') ||
                        (isset($access['Purchase']) && $access['Purchase']['add'] == '1') ||
                        (isset($access['Payment']) && $access['Payment']['add'] == '1') ||
                        (isset($access['Receipt']) && $access['Receipt']['add'] == '1') ||
                        (isset($access['Sale_Return']) && $access['Sale_Return']['add'] == '1') ||
                        (isset($access['Purchase_Return']) && $access['Purchase_Return']['add'] == '1') ||
                        (isset($access['Journal']) && $access['Journal']['add'] == '1') ||
                        (isset($access['Stock_journal']) && $access['Stock_journal']['add'] == '1'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                            <i class='ri-file-list-3-line'></i> <span data-key="t-layouts">Vouchers</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts">
                            <ul class="nav nav-sm flex-column">
                                @if (isset($access['Order']) && $access['Order']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vch.gst.create', 'order') }}" class="nav-link"
                                            data-key="t-horizontal">Orders</a>
                                    </li>
                                @endif
                                @if (isset($access['Sale']) && $access['Sale']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vch.gst.create', 'sale') }}" class="nav-link"
                                            data-key="t-detached">Sale</a>
                                    </li>
                                @endif
                                @if (isset($access['Sale_Return']) && $access['Sale_Return']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vch.gst.create', 'sale_return') }}" class="nav-link"
                                            data-key="t-detached">Sale Return</a>
                                    </li>
                                @endif
                                @if (isset($access['Purchase']) && $access['Purchase']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vch.gst.create', 'purchase') }}" class="nav-link"
                                            data-key="t-two-column">Purchase</a>
                                    </li>
                                @endif
                                @if (isset($access['Purchase_Return']) && $access['Purchase_Return']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vch.gst.create', 'purchase_return') }}" class="nav-link"
                                            data-key="t-two-column">Purchase Return</a>
                                    </li>
                                @endif
                                @if (isset($access['Payment']) && $access['Payment']['add'] == '1')
                                <li class="nav-item">
                                    <a href="{{ route('vch.pr.create', 'payment') }}" class="nav-link"
                                        data-key="t-two-column">Payment</a>
                                </li>
                            @endif    @if (isset($access['Receipt']) && $access['Receipt']['add'] == '1')
                            <li class="nav-item">
                                <a href="{{ route('vch.pr.create', 'receipt') }}" class="nav-link"
                                    data-key="t-two-column">Receipt</a>
                            </li>
                        @endif
                                @if (isset($access['Stock_journal']) && $access['Stock_journal']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vchstockjournal.create', 'Stock_journal') }}"
                                            class="nav-link" data-key="t-two-column">Stock Journal</a>
                                    </li>
                                @endif
                                @if (isset($access['Journal']) && $access['Journal']['add'] == '1')
                                    <li class="nav-item">
                                        <a href="{{ route('vchjournal.create', 'Journal') }}" class="nav-link"
                                            data-key="t-two-column">Journal</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

           @if (
                    (isset($access['Reports']) && is_array($access['Reports'])) ||
                        (isset($access['Day_Report']) && $access['Day_Report']['add'] == '1') ||
                        (isset($access['Ledger_Report']) && $access['Ledger_Report']['add'] == '1') ||
                        (isset($access['Group_Report']) && $access['Group_Report']['add'] == '1') ||
                        (isset($access['Godown_Wise_Stock_Report']) && $access['Godown_Wise_Stock_Report']['add'] == '1') ||
                        (isset($access['Minimum_Stock_Qty_Report']) && $access['Minimum_Stock_Qty_Report']['add'] == '1') ||
                        (isset($access['Sale_Report']) && $access['Sale_Report']['add'] == '1') ||
                        (isset($access['Sale_Return_Report']) && $access['Sale_Return_Report']['add'] == '1') ||
                        (isset($access['Purchase_Report']) && $access['Purchase_Report']['add'] == '1') ||
                        (isset($access['Sale_Report']) && $access['Sale_Report']['add'] == '1') ||
                        (isset($access['Sale_Return_Report']) && $access['Sale_Return_Report']['add'] == '1') ||
                        (isset($access['Purchase_Return_Report']) && $access['Purchase_Return_Report']['add'] == '1') ||
                        (isset($access['30_Days_debtors_Report']) && $access['30_Days_debtors_Report']['add'] == '1') ||
                        (isset($access['Sale_Order_Difference_Report']) && $access['Sale_Order_Difference_Report']['add'] == '1') ||
                        (isset($access['Receivable_Report']) && $access['Receivable_Report']['add'] == '1') ||
                        (isset($access['Inactive_Customer']) && $access['Inactive_Customer']['add'] == '1') ||
                        (isset($access['Payable_Report']) && $access['Payable_Report']['add'] == '1') ||
                        (isset($access['Payment_Report']) && $access['Payment_Report']['add'] == '1') ||
                        (isset($access['Bank_Balance_Report']) && $access['Bank_Balance_Report']['add'] == '1') ||
                        (isset($access['Receipt_Report']) && $access['Receipt_Report']['add'] == '1') ||
                        (isset($access['Order_Summary_Report']) && $access['Order_Summary_Report']['add'] == '1') ||
                        (isset($access['Order_Report']) && $access['Order_Report']['add'] == '1') ||
                        (isset($access['voucher_Report']) && $access['voucher_Report']['add'] == '1') ||
                        (isset($access['Highest_Customer_Report']) && $access['Highest_Customer_Report']['add'] == '1'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('report.index') }}">
                            <i class='ri-file-text-fill'></i> <span data-key="t-dashboards">Reports</span>
                        </a>
                    </li>
                @endif
                <li class='nav-item'>
                    <a id='menu-masters4' class='nav-link menu-link' href='#' data-bs-toggle='collapse'
                        data-bs-target='#masters4'>
                        <i class='ri-settings-3-fill'></i>
                        <span>Settings</span>
                    </a>
                    <div class='collapse menu-dropdown' id='masters4'>
                        <ul class='nav nav-sm flex-column'>
                           @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'SuperAdmin')
                                <li class="nav-item">
                                    <a href="{{ route('company.edit') }}" class="nav-link"
                                        data-key="t-calendar">Company
                                        Profile</a>
                                </li>
                            @endif

                            <li class='nav-item'>
                                <a id='menu-reports' class='nav-link' href='change-password.php'>
                                    Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->

@extends('layouts.app', ['title' => 'Reports'])

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    @php
        $permissions = Auth::user()->permission;
        $access = unserialize($permissions);
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">All Reports
                    </h4>
                </div>
                <div class="container">
                    <div class="col">
                        <form class="app-search ">
                            <div class="position-relative" style=" border-radius: 5px; border:1px solid black">
                                <input type="text" class="form-control shadow-lg p-3 mb-1 bg-white rounded"
                                    placeholder="Search..." autofocus autocomplete="off" id="desktopInputSearch"
                                    value="">
                                <span class="mdi mdi-magnify  search-widget-icon search-widget-icon-close "
                                    id="search-close-options"></span>
                            </div>
                        </form>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="all" role="tabpanel">
                                <div class="pb-3">
                                    <ul class="list-group" id='reports-ul'>
                                        @if (isset($access['Day_Report']) && $access['Day_Report']['add'] == '1')
                                            <li class="list-group-item" id="day-reports">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.day') }}" class="fw-semibold">
                                                    Day Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Ledger_Report']) && $access['Ledger_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.trail-balance.view') }}" class="fw-semibold">
                                                    Ledger Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Group_Report']) && $access['Group_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.group') }}" class="fw-semibold">
                                                    Group Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Godown_Wise_Stock_Report']) && $access['Godown_Wise_Stock_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.godownstock_report') }}" class="fw-semibold">
                                                    Godown wise Stock Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Minimum_Stock_Qty_Report']) && $access['Minimum_Stock_Qty_Report']['add'] == '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.minstockqty.view') }}" class="fw-semibold">
                                                    Minimum Stock Qty Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Sale_Report']) && $access['Sale_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a class="fw-semibold">Sale Report :</a>
                                                <a href="{{ route('report.sale.monthly', ['vch_type' => 'sale']) }}"
                                                    class="fw-semibold"> Monthly </a>
                                                |
                                                <a href="{{ route('vch.gst.index', ['vch_type' => 'sale']) }}"
                                                    class="fw-semibold">
                                                    All</a>
                                            </li>
                                        @endif
                                        @if (isset($access['Sale_Return_Report']) && $access['Sale_Return_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a route="" class="fw-semibold">Sale Return Report :</a>
                                                <a href="{{ route('report.sale.monthly', ['vch_type' => 'sale_return']) }}"
                                                    class="fw-semibold">
                                                    Monthly </a> |
                                                <a href="{{ route('vch.gst.index', ['vch_type' => 'sale_return']) }}"
                                                    class="fw-semibold"> All</a>
                                            </li>
                                        @endif
                                        @if (isset($access['Purchase_Report']) && $access['Purchase_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a route="" class="fw-semibold">Purchase Report :</a>
                                                <a href="{{ route('report.sale.monthly', ['vch_type' => 'purchase']) }}"
                                                    class="fw-semibold"> Monthly
                                                </a> |
                                                <a class="fw-semibold"
                                                    href="{{ route('vch.gst.index', ['vch_type' => 'purchase']) }}">
                                                    All</a>
                                            </li>
                                        @endif
                                        @if (isset($access['Purchase_Return_Report']) && $access['Purchase_Return_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a route="" class="fw-semibold">
                                                    Purchase Return Report:
                                                    <a href="{{ route('report.sale.monthly', ['vch_type' => 'purchase_return']) }}"
                                                        class="fw-semibold">
                                                        Monthly </a> |
                                                    <a
                                                        href="{{ route('vch.gst.index', ['vch_type' => 'purchase_return']) }}"class="fw-semibold">
                                                        All</a>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['30_Days_debtors_Report']) && $access['30_Days_debtors_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.report30daysdebtors') }}" class="fw-semibold">
                                                    30 Days Debtors Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Highest_Customer_Report']) && $access['Highest_Customer_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href="{{ route('report.highestcustomer') }}" class="fw-semibold">
                                                    Highest Customer Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Sale_Order_Difference_Report']) && $access['Sale_Order_Difference_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.ordersaledifference.view') }}" class="fw-semibold">
                                                    Order Sale Difference Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Inactive_Customer']) && $access['Inactive_Customer']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.inactivereport') }}" class="fw-semibold">
                                                    Inactive Customer
                                                </a>
                                            </li>
                                        @endif
                                         @if (isset($access['Receivable_Report']) && $access['Receivable_Report']['add'] == '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.receivable.view') }}" class="fw-semibold">
                                                    Receivable Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Payable_Report']) && $access['Payable_Report']['add'] == '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.payable.view') }}" class="fw-semibold">
                                                    Payable Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Order_Summary_Report']) && $access['Order_Summary_Report']['add'] == '1')
                                            <li class="list-group-item" id="">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('order.summary.view') }}" class="fw-semibold">
                                                    Order Summary Report
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($access['Order_Report']) && $access['Order_Report']['add'] == '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.order') }}" class="fw-semibold">
                                                    Order Report
                                                </a>
                                            </li>
                                        @endif
                                        
                                        @if (isset($access['voucher_Report']) && $access['voucher_Report']['add'] == '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.voucher.view') }}" class="fw-semibold">
                                                    Voucher Report
                                                </a>
                                            </li>
                                        @endif
                                        
                                        @if (isset($access['Bank_Balance_Report']) && $access['Bank_Balance_Report']['add'] === '1')
                                            <li class="list-group-item">
                                                <i class="ri-bill-line align-middle me-2"></i>
                                                <a href=" {{ route('report.bank') }}" class="fw-semibold">
                                                    Bank Balance Report
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Function to handle search logic for desktop search input -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#desktopInputSearch").on("input", function() {
                var searchText = $(this).val()
                    .toLowerCase(); // Get the search text and convert to lowercase
                $("#reports-ul li").each(function() {
                    var listItemText = $(this).find("a").text()
                        .toLowerCase(); // Get the text in the <a> tag and convert to lowercase
                    if (listItemText.includes(searchText)) {
                        $(this).show(); // If the text matches, show the <li> element
                    } else {
                        $(this).hide(); // If not, hide the <li> element
                    }
                });
            });
        });
    </script>
@endsection

@push('scripts')

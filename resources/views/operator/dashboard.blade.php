@extends('layouts.app')
@section('title','Dashboard')

@section('operator_content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <!-- Greetings -->
            <div class="col-lg-8 mb-4 order-0">
                <div class="card" style="padding-bottom:15px">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Hello {{ ucfirst(Auth::user()->name) }} !</h5>
                                <p class="mb-4">
                                    You have <span id="percentToday" class="fw-bold">0</span><span class="fw-bold">%</span><span id="moreLess"></span> trips today. Check real time trips in the trip records section.
                                </p>
                                <a href="./operator-trip" class="btn btn-sm btn-outline-primary">View Trips</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body" >
                                <img src="../assets/img/illustrations/bus-driver2.svg" height="150" alt="Bus Driver" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Small Cards -->
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">

                    <!-- Trips -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="alert-success rounded" style="padding:10px">
                                        <i class="bx bx-trip" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <button class="dropdown-item" id="tToday">Today</button>
                                            <button class="dropdown-item" id="tMonth">This Month</button>
                                            <button class="dropdown-item" id="tYear">This Year</button>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-success small mb-0" id="trips">Today</span>
                                <span class="d-block mb-1">Trips</span>
                                <?php $cnt = 0; $cnt1 = 0; $cnt2 = 0; $cnt3 = 0;?>
                                @foreach($trips as $tr)
                                    @if($tr->personnel_schedule->operator_id == Auth::user()->personnel_id)
                                    <?php $cnt++;?>
                                    @endif
                                @endforeach
                                @foreach($trip_today as $trt)
                                    @if($trt->personnel_schedule->operator_id == Auth::user()->personnel_id)
                                    <?php $cnt1++;?>
                                    @endif
                                @endforeach
                                @foreach($trip_month as $trm)
                                    @if($trm->personnel_schedule->operator_id == Auth::user()->personnel_id)
                                    <?php $cnt2++;?>
                                    @endif
                                @endforeach
                                @foreach($trip_year as $try)
                                    @if($try->personnel_schedule->operator_id == Auth::user()->personnel_id)
                                    <?php $cnt3++;?>
                                    @endif
                                @endforeach
                                <?php 
                                    $old = $cnt;
                                    $diff_today = $cnt1 - $old;
                                    $diff_month = $cnt2 - $old;
                                    $diff_year = $cnt3 - $old;
                                    $more_less_today = $diff_today >= 0 ? "increase" : "decrease";
                                    $more_less_month = $diff_month >= 0 ? "increase" : "decrease";
                                    $more_less_year = $diff_year >= 0 ? "increase" : "decrease";
                                    if($cnt1 !=0){
                                        $diff_today = abs($diff_today);
                                        $percentChange_today = ($diff_today/$old)*100;
                                        $percent_today = number_format((float)$percentChange_today, 1, '.', '');
                                    }else{
                                        $percent_today = 0;
                                    }

                                    if($cnt2 !=0){
                                        $diff_month = abs($diff_month);
                                        $percentChange_month = ($diff_month/$old)*100;
                                        $percent_month = number_format((float)$percentChange_month, 1, '.', '');
                                    }else{
                                        $percent_month = 0;
                                    }

                                    if($cnt3 !=0){
                                        $diff_year = abs($diff_year);
                                        $percentChange_year = ($diff_year/$old)*100;
                                        $percent_year = number_format((float)$percentChange_year, 1, '.', '');
                                    }else{
                                        $percent_year = 0;
                                    }
                                    ?>
                                <h3 class="card-title mb-2" id="tripToday">{{$cnt1}}</h3>
                                <h3 class="card-title mb-2" id="tripMonth" style="display:none">{{$cnt2}}</h3>
                                <h3 class="card-title mb-2" id="tripYear" style="display:none">{{$cnt3}}</h3>
                                @if($more_less_today == 'increase')
                                    <small id="tripPercentToday" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_today}}%</small>
                                @else
                                    <small id="tripPercentToday" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_today}}%</small>
                                @endif

                                @if($more_less_month == 'increase')
                                    <small id="tripPercentMonth" style="display:none" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_month}}%</small>
                                @else
                                    <small id="tripPercentMonth" style="display:none" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_month}}%</small>
                                @endif

                                @if($more_less_year == 'increase')
                                    <small id="tripPercentYear" style="display:none" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_year}}%</small>
                                @else
                                    <small id="tripPercentYear" style="display:none" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_year}}%</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Schedules -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="alert-warning rounded" style="padding:10px">
                                        <i class="bx bx-calendar" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" id="sToday">Today</a>
                                            <a class="dropdown-item" id="sMonth">This Month</a>
                                            <a class="dropdown-item" id="sYear">This Year</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-warning small mb-0" id="perscheds">Today</span>
                                <span class="d-block mb-1">Schedules</span>
                                <?php $cns = 0; $cns1 = 0; $cns2 = 0; $cns3 = 0; ?>
                                @foreach($perscheds as $ps)
                                    @if($ps->operator_id == Auth::user()->personnel_id)
                                    <?php $cns++;?>
                                    @endif
                                @endforeach
                                @foreach($persched_today as $pst)
                                    @if($pst->operator_id == Auth::user()->personnel_id)
                                    <?php $cns1++;?>
                                    @endif
                                @endforeach
                                @foreach($persched_month as $psm)
                                    @if($psm->operator_id == Auth::user()->personnel_id)
                                    <?php $cns2++;?>
                                    @endif
                                @endforeach
                                @foreach($persched_year as $psy)
                                    @if($psy->operator_id == Auth::user()->personnel_id)
                                    <?php $cns3++;?>
                                    @endif
                                @endforeach
                                <?php 
                                    $old_s = $cns;
                                    $diff_today_s = $cns1 - $old_s;
                                    $diff_month_s = $cns2 - $old_s;
                                    $diff_year_s = $cns3 - $old_s;
                                    $more_less_today_s = $diff_today_s >= 0 ? "increase" : "decrease";
                                    $more_less_month_s = $diff_month_s >= 0 ? "increase" : "decrease";
                                    $more_less_year_s = $diff_year_s >= 0 ? "increase" : "decrease";
                                    if($cns1 !=0){
                                        $diff_today_s = abs($diff_today_s);
                                        $percentChange_today_s = ($diff_today_s/$old_s)*100;
                                        $percent_today_s = number_format((float)$percentChange_today_s, 1, '.', '');
                                    }else{
                                        $percent_today_s = 0;
                                    }

                                    if($cns2 !=0){
                                        $diff_month_s = abs($diff_month_s);
                                        $percentChange_month_s = ($diff_month_s/$old_s)*100;
                                        $percent_month_s = number_format((float)$percentChange_month_s, 1, '.', '');
                                    }else{
                                        $percent_month_s = 0;
                                    }

                                    if($cns3 !=0){
                                        $diff_year_s = abs($diff_year_s);
                                        $percentChange_year_s = ($diff_year_s/$old_s)*100;
                                        $percent_year_s = number_format((float)$percentChange_year_s, 1, '.', '');
                                    }else{
                                        $percent_year_s = 0;
                                    }
                                    ?>
                                <h3 class="card-title mb-2" id="perschedToday">{{$cns1}}</h3>
                                <h3 class="card-title mb-2" id="perschedMonth" style="display:none">{{$cns2}}</h3>
                                <h3 class="card-title mb-2" id="perschedYear" style="display:none">{{$cns3}}</h3>
                                @if($more_less_today_s == 'increase')
                                    <small id="perschedPercentToday" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_today_s}}%</small>
                                @else
                                    <small id="perschedPercentToday" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_today_s}}%</small>
                                @endif

                                @if($more_less_month_s == 'increase')
                                    <small id="perschedPercentMonth" style="display:none" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_month_s}}%</small>
                                @else
                                    <small id="perschedPercentMonth" style="display:none" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_month_s}}%</small>
                                @endif

                                @if($more_less_year_s == 'increase')
                                    <small id="perschedPercentYear" style="display:none" class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +{{$percent_year_s}}%</small>
                                @else
                                    <small id="perschedPercentYear" style="display:none" class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -{{$percent_year_s}}%</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trip Records -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card" style="padding-bottom:21px">
                    <div class="row row-bordered g-0 mb-2">
                        <div class="col-md-12">
                            <h6 class="card-header m-0 me-2 pb-3">Trip Records 
                                <span class="badge bg-label-primary rounded-pill">This Year</span>
                            </h6>
                            <div id="columnChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Small Cards -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                
                    <!-- Announcements -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header align-items-center justify-content-between pb-0">
                                <div class="card-title mb-0">
                                    <h6 class="m-0 me-2">Announcements <span class="badge bg-label-primary rounded-pill">Recent</span></h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0 mt-4">
                                    <li class="d-flex mb-1 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-envelope"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{$announce->subject}}</h6>
                                                <?php
                                                    $user_type = '';
                                                    if($announce->user_type == 1){
                                                        $user_type = 'All';
                                                    }else if($announce->user_type == 2){
                                                        $user_type = 'Conductors';
                                                    }else if($announce->user_type == 3){
                                                        $user_type = 'Dispatchers';
                                                    }else if($announce->user_type == 4){
                                                        $user_type = 'Operators';
                                                    }else if($announce->user_type == 5){
                                                        $user_type = 'Passengers';
                                                    }else if($announce->user_type == 6){
                                                        $user_type = 'All Personnel';
                                                    }
                                                ?>
                                                <p class="small mb-1">To: {{$user_type}}</p>
                                            </div>
                                            <small class="text-muted mb-2">{{$announce->message}}</small>
                                                <?php
                                                    $date = new DateTime($announce->created_at);
                                                    $result = $date->format('F j, Y, g:i a');
                                                ?>
                                            <small class="fw-semibold">{{$result}}</small>
                                        </div>
                                    </li>                                        

                                    <li class="d-flex mb-1 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <a href="./operator-announcement" class="btn btn-sm btn-outline-primary">View Messages</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Duration -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body" style="padding-bottom:20px;">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h6 class="text-nowrap mb-2">Trip Duration <span class="badge bg-label-primary rounded-pill">This Year</span></h6>
                                            
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-1" id="duration">0</h3>
                                            <span class="text-secondary  medium"> minutes</span>
                                        </div>
                                    </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('scripts')
    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-operator-dashboard').addClass('active open')
        $('[id^="menu-"]').removeClass('active')

        per = @json($percent_today);
        more_less = @json($more_less_today);
        duration = @json($total_minutes);
        ongoing_trip = @json($ongoing_trip);
        arrived_trip = @json($arrived_trip);
        cancelled_trip = @json($cancelled_trip);
        duration_trip = @json($duration_trip);

        document.addEventListener("DOMContentLoaded", () => {
            // Duration
            $('#duration').html(duration);

            // Trip Card
            $('#tripToday').show();
            $('#tripPercentToday').show();
            $('#percentToday').html(per);
            if(more_less == 'increase'){
                $('#moreLess').html(' more');
            }else if(more_less == 'decrease'){
                $('#moreLess').html(' less');
            }else{
                $('#moreLess').html('');
            }

            // Schedule Card
            $('#perschedToday').show();
            $('#perschedPercentToday').show();

            // Bus Card
            $('#busToday').show();
            $('#busPercentToday').show();

            // Personnel Card
            $('#personnelToday').show();
            $('#personnelPercentToday').show();

            new ApexCharts(document.querySelector("#profileReportChart"), {
                chart: {
                    height: 80,
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 10,
                        left: 5,
                        blur: 3,
                        color: config.colors.primary,
                        opacity: 0.15
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                grid: {
                    show: false,
                    padding: {
                        right: 8
                    }
                },
                colors: [config.colors.primary],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 5,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Duration',
                    data: duration_trip
                }],
                xaxis: {
                    categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov','Dec'],
                    show: false,
                    lines: {
                        show: false
                    },
                    labels: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                }
            }).render();

            new ApexCharts(document.querySelector("#columnChart"), {
                series: [{
                    name: 'Cancelled',
                    data: cancelled_trip
                    }, {
                    name: 'Arrived',
                    data: arrived_trip
                    }, {
                    name: 'Ongoing',
                    data: ongoing_trip
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov','Dec'],
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                        return val + " Trips"
                        }
                    }
                }
            }).render();
        });

        // Trip Onclick Card
        $('#tToday').on('click', function () {
            $('#trips').html('Today');
            $('#tripToday').show();
            $('#tripMonth').hide();
            $('#tripYear').hide();
            $('#tripPercentToday').show();
            $('#tripPercentMonth').hide();
            $('#tripPercentYear').hide();
        });
        $('#tMonth').on('click', function () {
            $('#trips').html('This Month');
            $('#tripToday').hide();
            $('#tripMonth').show();
            $('#tripYear').hide();
            $('#tripPercentToday').hide();
            $('#tripPercentMonth').show();
            $('#tripPercentYear').hide();
        });
        $('#tYear').on('click', function () {
            $('#trips').html('This Year');
            $('#tripToday').hide();
            $('#tripMonth').hide();
            $('#tripYear').show();
            $('#tripPercentToday').hide();
            $('#tripPercentMonth').hide();
            $('#tripPercentYear').show();
        });

        // Schedule Onclick Card
        $('#sToday').on('click', function () {
            $('#perscheds').html('Today');
            $('#perschedToday').show();
            $('#perschedMonth').hide();
            $('#perschedYear').hide();
            $('#perschedPercentToday').show();
            $('#perschedPercentMonth').hide();
            $('#perschedPercentYear').hide();
        });
        $('#sMonth').on('click', function () {
            $('#perscheds').html('This Month');
            $('#perschedToday').hide();
            $('#perschedMonth').show();
            $('#perschedYear').hide();
            $('#perschedPercentToday').hide();
            $('#perschedPercentMonth').show();
            $('#perschedPercentYear').hide();
        });
        $('#sYear').on('click', function () {
            $('#perscheds').html('This Year');
            $('#perschedToday').hide();
            $('#perschedMonth').hide();
            $('#perschedYear').show();
            $('#perschedPercentToday').hide();
            $('#perschedPercentMonth').hide();
            $('#perschedPercentYear').show();
        });

        // Bus Onclick Card
        $('#bToday').on('click', function () {
            $('#buses').html('Today');
            $('#busToday').show();
            $('#busMonth').hide();
            $('#busYear').hide();
            $('#busPercentToday').show();
            $('#busPercentMonth').hide();
            $('#busPercentYear').hide();
        });
        $('#bMonth').on('click', function () {
            $('#buses').html('This Month');
            $('#busToday').hide();
            $('#busMonth').show();
            $('#busYear').hide();
            $('#busPercentToday').hide();
            $('#busPercentMonth').show();
            $('#busPercentYear').hide();
        });
        $('#bYear').on('click', function () {
            $('#buses').html('This Year');
            $('#busToday').hide();
            $('#busMonth').hide();
            $('#busYear').show();
            $('#busPercentToday').hide();
            $('#busPercentMonth').hide();
            $('#busPercentYear').show();
        });

        // Personnel Onclick Card
        $('#pToday').on('click', function () {
            $('#personnels').html('Today');
            $('#personnelToday').show();
            $('#personnelMonth').hide();
            $('#personnelYear').hide();
            $('#personnelPercentToday').show();
            $('#personnelPercentMonth').hide();
            $('#personnelPercentYear').hide();
        });
        $('#pMonth').on('click', function () {
            $('#personnels').html('This Month');
            $('#personnelToday').hide();
            $('#personnelMonth').show();
            $('#personnelYear').hide();
            $('#personnelPercentToday').hide();
            $('#personnelPercentMonth').show();
            $('#personnelPercentYear').hide();
        });
        $('#pYear').on('click', function () {
            $('#personnels').html('This Year');
            $('#personnelToday').hide();
            $('#personnelMonth').hide();
            $('#personnelYear').show();
            $('#personnelPercentToday').hide();
            $('#personnelPercentMonth').hide();
            $('#personnelPercentYear').show();
        });
    </script>
@endsection
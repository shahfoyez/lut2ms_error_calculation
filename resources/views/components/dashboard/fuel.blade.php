  <!--begin::fuel-->
<!--begin::Row-->
<div class="row g-5 g-xl-8">
    <!--begin::Col-->
    <div class="col-xl-4">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0">
                <h3 class="card-title fw-bolder text-dark">Fuel</h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0">
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-success me-5">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="flex-grow-1 me-2">
                        <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Total Fuel</a>
                        <span class="text-muted fw-bold d-block">Last 12 Months</span>
                    </div>
                    <!--end::Title-->
                    <!--begin::Lable-->
                    <span class="fw-bolder text-success py-1">{{ $fuelsData['total_fuels'] }} Liters</span>
                    <!--end::Lable-->
                </div>
                <!--end::Item-->


                    <!--begin::Item-->
                    <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-success me-5">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="flex-grow-1 me-2">
                        <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Average Per Month</a>
                        <span class="text-muted fw-bold d-block">Last 12 Months</span>
                    </div>
                    <!--end::Title-->
                    <!--begin::Lable-->
                    <span class="fw-bolder text-success py-1">{{ $fuelsData['avg_fuels'] }} Liters</span>
                    <!--end::Lable-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-success me-5">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="flex-grow-1 me-2">
                        <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">This Month</a>
                        <span class="text-muted fw-bold d-block">Month of {{ $fuelsData['fuel_cur_month'] }}</span>
                    </div>
                    <!--end::Title-->
                    <!--begin::Lable-->
                    <span class="fw-bolder text-success py-1">{{ $fuelsData['cur_month_fuels'] }} Liters</span>
                    @include('components.arrowIndicator.fuelArrowIndicator')
                    <!--end::Lable-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-success me-5">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="flex-grow-1 me-2">
                        <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Last Month</a>
                        <span class="text-muted fw-bold d-block">Month of {{ $fuelsData['fuel_last_month'] }}</span>
                    </div>
                    <!--end::Title-->
                    <!--begin::Lable-->
                    <span class="fw-bolder text-success py-1">{{ $fuelsData['last_month_fuels'] }} Liters</span>
                    <!--end::Lable-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Body-->
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Mixed Widget 12-->
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 bg-success py-5">
                <h3 class="card-title fw-bolder text-white">Fuels Stats</h3>
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button type="button" class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color- border-0 me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                                    <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                    <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                    <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                    <!--begin::Menu 3-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Fuel</div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ url('/requisition/vehicles') }}" class="menu-link px-3">Vehicles</a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ url('/trip/history') }}" class="menu-link px-3">Trip History</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 3-->
                    <!--end::Menu-->
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body p-0">
                <!--begin::Chart-->
                <div id="fuelsChart" class="p-5">
                </div>
                <!--end::Chart-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 12-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<!--end::fuel-->
@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{-- <script src="{{ asset('/assets/js/charts/maintenance.js') }}"></script>
    <script src="{{ asset('/assets/js/charts/fuel.js') }}"></script>
    <script src="{{ asset('/assets/js/charts/trip.js') }}"></script> --}}
    <script>
    //     let maintenanceData = {!! json_encode($maintenanceData) !!};
    //     var labels =  maintenanceData.labels;
    //     var costValues = maintenanceData.costValues;
    //     var options = {
    //       series: [
    //         {
    //         name: 'Taka',
    //         type: 'column',
    //         data: costValues
    //         },
    //         {
    //         name: 'Taka',
    //         type: 'line',
    //         data: costValues
    //         }
    //     ],
    //       chart: {
    //       height: 350,
    //       type: 'line',
    //     },
    //     stroke: {
    //       width: [0, 4]
    //     },
    //     dataLabels: {
    //       enabled: true,
    //       enabledOnSeries: [1]
    //     },
    //     labels: labels,
    //     xaxis: {
    //       type: 'text'
    //     },
    //     yaxis: [
    //         {
    //             title: {
    //                 text: 'Taka',
    //             },
    //         },
    //     ]
    //     };
    //     var chart = new ApexCharts(document.querySelector("#chart"), options);
    //     chart.render();
    // </script>
    // {{-- Trips Chart --}}
    // <script>
    //     let tripsData = {!! json_encode($tripsData) !!};
    //     var trips_labels = tripsData.trips_labels;
    //     var trips_count_values = tripsData.trips_count_values;
    //     var trips = {
    //       series: [
    //         {
    //         name: 'Trips',
    //         type: 'column',
    //         data: trips_count_values
    //         },
    //         {
    //         name: 'Trips',
    //         type: 'line',
    //         data: trips_count_values
    //         }
    //     ],
    //       chart: {
    //       height: 350,
    //       type: 'line',
    //     },
    //     stroke: {
    //       width: [0, 4]
    //     },
    //     dataLabels: {
    //       enabled: true,
    //       enabledOnSeries: [1]
    //     },
    //     labels: trips_labels,
    //     xaxis: {
    //       type: 'text'
    //     },
    //     yaxis: [
    //         {
    //             title: {
    //                 text: 'Number of Trips',
    //             },
    //         },
    //     ]
    //     };
    //     var tripsChart = new ApexCharts(document.querySelector("#tripsChart"), trips);
    //     tripsChart.render();
    // </script>

    {{-- Fuels Chart --}}
    <script>
        let fuelsData = {!! json_encode($fuelsData) !!};
        var fuels_labels = fuelsData.fuels_labels;
        var fuels_count_values = fuelsData.fuels_count_values;
        var fuels_cost_values = fuelsData.fuels_cost_values;
        var fuels = {
          series: [{
          name: 'Cost',
          type: 'column',
          data: fuels_cost_values
        }, {
          name: 'Quantity',
          type: 'line',
          data: fuels_count_values
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: [0, 4]
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [1]
        },
        labels: fuels_labels,
        xaxis: {
          type: 'text'
        },
        yaxis: [{
          title: {
            text: 'Cost',
          },

        }, {
          opposite: true,
          title: {
            text: 'Quantity'
          }
        }]
        };

        var fuelsChart = new ApexCharts(document.querySelector("#fuelsChart"), fuels);
        fuelsChart.render();
    </script>
@endsection

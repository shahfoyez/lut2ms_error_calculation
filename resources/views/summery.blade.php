@extends('layouts.dashboardMaster')
@section('title')
    Summery
@endsection
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    {{-- <div class="foy-errors container-xxl">
        @include('components.success')
        @include('components.error')
    </div> --}}

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::errors-->
            @include('components.flashMessage')
            @include('components.success')
            @include('components.error')
            <!--end::errors-->

            <!--begin::Tables Widget 11-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Summery
                            <span class="card-label text-muted">
                                @if (isset($start) && isset($end))
                                    {{ '('.$start.'-'.$end.')' }}
                                @endif
                            </span>
                        </span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $vehicles->count() }} Vehicle</span>
                    </h3>
                    <div class="card-toolbar">
                        <?php
                            $formAction = url('/summery/filter');
                            $refreshAction = url('/summery/table');
                        ?>
                        @include('components.filter.dateFilter')
                        @include('components.filter.filterRefresh')
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 border rounded">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th >Sl</th>
                                    <th>vehicle</th>
                                    <th>Type</th>
                                    <th>Capacity</th>
                                    <th>Trips</th>
                                    <th>Fuel</th>
                                    <th>Cost</th>

                                    <th>FE</th>
                                    <th>LE</th>
                                    <th>Run</th>
                                    <th>AKPL</th>
                                    <th class="text-end">KPL</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @if($vehicles && $vehicles->count()>0)
                                    @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td>
                                            @include('components.tableSerial')
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-5">
                                                    <img src="{{ $vehicle->image ? asset($vehicle->image) : asset('assets/uploads/default/defaultVehicle.webp') }}" class="" alt="" />
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <p href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ $vehicle->codeName }}</p>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">License: {{ $vehicle->license }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->type){
                                                    $type = $vehicle->type;
                                                    $typeClass = "";
                                                }else{
                                                    $type = "No Data";
                                                    $typeClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $typeClass }}">{{ ucfirst($vehicle->vehicleType->name) }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>
                                        <td>
                                            <span class="badge badge-square badge-success">{{ $vehicle->capacity }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-square badge-success">{{ $vehicle->trips_count }}</span>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->fuels_sum_quantity){
                                                    $consumed = $vehicle->fuels_sum_quantity." Litters";
                                                    $consumedClass = "";
                                                }else{
                                                    $consumed = "No Data";
                                                    $consumedClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $consumedClass }}">{{ $consumed }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->fuels_sum_cost){
                                                    $cost = "TK: ".$vehicle->fuels_sum_cost;
                                                    $costClass = "";
                                                }else{
                                                    $cost = "No Data";
                                                    $costClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $costClass }}">{{ $cost }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>

                                        <td>
                                            @php
                                                if ($vehicle->meter_entries_min_meter_entry){
                                                    $first_entry =  $vehicle->meter_entries_min_meter_entry;
                                                    $fe_Class = "";
                                                }else{
                                                    $first_entry = "No Data";
                                                    $fe_Class = "text-muted";
                                                }
                                            @endphp
                                            <p class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $fe_Class }}">{{ $first_entry }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->meter_entries_max_meter_entry){
                                                    $last_entry =  $vehicle->meter_entries_max_meter_entry;
                                                    $le_Class = "";
                                                }else{
                                                    $last_entry = "No Data";
                                                    $le_Class = "text-muted";
                                                }
                                            @endphp
                                            <p class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $le_Class }}">{{ $last_entry }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>

                                        <td>
                                            @php
                                                if ($vehicle->meter_entries_max_meter_entry){
                                                    $minEntry = $vehicle->meter_entries_min_meter_entry;
                                                    $maxEntry = $vehicle->meter_entries_max_meter_entry;
                                                    $entryClass = "";
                                                    $totalRun = ($maxEntry - $minEntry)." Km";
                                                }else{
                                                    $totalRun = "No Data";
                                                    $entryClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $entryClass }}">{{  $totalRun  }}</p>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->first_last_entries_max_meter_entry && $vehicle->total_fuels_sum_quantity){
                                                    $minEntry =  $vehicle->first_last_entries_min_meter_entry;

                                                    $maxEntry = $vehicle->first_last_entries_max_meter_entry;

                                                    $TotalConsumed = $vehicle->total_fuels_sum_quantity;
                                                    $totalRun = $maxEntry - $minEntry;
                                                    $avg_kpl = $totalRun/$TotalConsumed;
                                                    $avg_kpl = number_format($totalRun/$TotalConsumed, 2)." Km/L";
                                                    $avg_kplClass = "";
                                                }else{
                                                    $avg_kpl = "No Data";
                                                    $avg_kplClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $avg_kplClass }}">{{   $avg_kpl  }}
                                            </p>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->meter_entries_max_meter_entry && $vehicle->fuels_sum_quantity){
                                                    $minEntry =  $vehicle->meter_entries_min_meter_entry;

                                                    $maxEntry = $vehicle->meter_entries_max_meter_entry;

                                                    $TotalConsumed = $vehicle->fuels_sum_quantity;
                                                    $totalRun = $maxEntry - $minEntry;
                                                    $kpl = $totalRun/$TotalConsumed;
                                                    $kpl = number_format($totalRun/$TotalConsumed, 2)." Km/L";
                                                    $kplClass = "";
                                                }else{
                                                    $kpl = "No Data";
                                                    $kplClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $kplClass }}">{{   $kpl  }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 11-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->
@endsection
@section('scripts')
    <script src="{{ asset('/assets/js/custom/documentation/forms/daterangepicker.js') }}"></script>

@endsection


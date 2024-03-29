@extends('layouts.dashboardMaster')
@section('title')
    Vehicles
@endsection
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                        <span class="card-label fw-bolder fs-3 mb-1">Vehicles
                            <span class="card-label text-muted">
                                @if (isset($start) && isset($end))
                                    {{ '('.$start.'-'.$end.')' }}
                                @endif
                            </span>
                        </span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $vehicles->count() }} Vehicles</span>
                    </h3>
                    <div class="card-toolbar">
                        <?php
                            $formAction = url('/maintenance/maintenanceVehicles/filter');
                            $refreshAction = url('/maintenance/maintenanceVehicles');
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
                                    <th class="w-20px">Sl</th>
                                    <th class="ps-4 min-w-325px rounded-start">Vehicle</th>
                                    <th class="min-w-125px">Total Entries</th>
                                    <th class="min-w-125px">Total Cost</th>
                                    <th class="min-w-125px">Last Entry</th>
                                    <th class="min-w-200px text-end rounded-end"></th>
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
                                                if ($vehicle->maintenance_entries_count){
                                                    $totalEntries = $vehicle->maintenance_entries_count;
                                                    $meClass = "badge-success";
                                                }else{
                                                    $totalEntries = 0;
                                                    $meClass = "badge-secondary";
                                                }
                                            @endphp
                                            <span class="badge badge-square {{ $meClass }}">{{ $totalEntries }}</span>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->maintenance_entries_sum_cost){
                                                    $totalCost = "TK: ".$vehicle->maintenance_entries_sum_cost."/=";
                                                    $entryClass = "";
                                                }else{
                                                    $totalCost = "No Data";
                                                    $entryClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $entryClass }}">{{  $totalCost  }}</p>
                                        </td>
                                        <td>
                                            @php
                                                if ($vehicle->maintenance_entries_max_from){
                                                    $maxDate = $vehicle->maintenance_entries_max_from->format('d M Y');
                                                    $maxTime = $vehicle->maintenance_entries_max_from->format('h:i A');
                                                    $maxClass = "";
                                                }else{
                                                    $maxDate = "No Data";
                                                    $maxTime = "";
                                                    $maxClass = "text-muted";
                                                }
                                            @endphp
                                             <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $maxClass }}">{{ $maxDate }}</p>
                                             <span class="text-muted fw-bold text-muted d-block fs-7">{{ $maxTime }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ url('/maintenance/maintenanceAdd/'.$vehicle->id) }}" class=" btn btn-primary p-2">
                                                +Entry
                                            </a>
                                            {{-- <a href="/requisition/send/{{ $vehicle->id }}" class=" btn btn-primary p-2">
                                                Records
                                            </a> --}}
                                            <a href="{{ url('/maintenance/vehicleMaintenanceRecords/'.$vehicle->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                                        </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
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

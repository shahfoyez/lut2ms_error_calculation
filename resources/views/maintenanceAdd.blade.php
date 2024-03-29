@extends('layouts.dashboardMaster')
@section('title')
    Add Fuel Record
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">

                    @include('components.success')
                    @include('components.error')

                <!--begin::Contact-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-17">
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-lg-10">
                                <!--begin::Form-->
                                <form action="{{ url('/maintenance/maintenanceEntryAdd') }}" class="form mb-15" method="post" id="">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Add Maintenance Entry</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Vehicle</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="vid" data-control="select2" data-placeholder="Select Vehicle" value="{{ old('vid') }}">
                                                <option></option>
                                                <?php
                                                if($vehicles->count()>0){
                                                    foreach($vehicles as $vehicle){
                                                    ?>
                                                        <option value="{{ $vehicle->id }}" {{ $vehicle->id == $selVehicle->id ? 'selected' : '' }}>{{ $vehicle->codeName }}</option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                            @error('vid')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">Cost</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="Cost(Taka)" name="cost" value="{{ old('cost') }}"/>
                                            @error('cost')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <?php
                                            $mindate = date("Y-m-d");
                                            $mintime = date("H:i");
                                            $min = $mindate."T".$mintime;

                                            $maxInputDate = date("Y-m-d", strtotime("+1 Days"));
                                            $maxInputTime= date("h:i");
                                            $maxInput = $maxInputDate."T".$maxInputTime;
                                        ?>
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">From</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="from" value="{{  old('from') ?? $min }}"/>
                                            @error('from')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                         <!--begin::Col-->
                                         <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label">To</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="to" value="{{  old('to') ??  $maxInput }}"/>
                                            @error('to')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-12 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label">Note</label>
                                            <textarea type="text-area" class="form-control" placeholder="Note(optional)" name="note" value="{{ old('note') }}" rows="3"></textarea>
                                            @error('note')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5" onClick="this.form.submit(); this.disabled=true; this.innerText='Wait...'; ">
                                        <!--begin::Indicator-->
                                        <span class="indicator-label">Submit</span>
                                        {{-- <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> --}}
                                        <!--end::Indicator-->
                                    </button>
                                    <!--end::Submit-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Contact-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection



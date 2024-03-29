@extends('layouts.dashboardMaster')
@section('title')
    Edit Employee
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="foy-errors container-xxl">
            @include('components.success')
            @include('components.error')
        </div>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Contact-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-17">
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-lg-10">
                                <!--begin::Form-->
                                <form action="{{ url('/employee/employeeUpdate/'.$employee->id) }}" class="form mb-15" method="post" id="" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit Employee</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Name</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-3 mb-lg-0" placeholder="name" value="{{ old('name')? old('name') : $employee->name }}" />
                                            @error('name')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">ID</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="idNumber" class="form-control mb-3 mb-lg-0" placeholder="ID" value="{{ old('idNumber')? old('idNumber') : $employee->idNumber }}"  />
                                            @error('idNumber')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Phone</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="tel" name="phone" class="form-control mb-3 mb-lg-0" placeholder="Phone" value="{{ old('phone')? old('phone') : $employee->phone }}"/>
                                            @error('phone')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2">Address</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="address" class="form-control mb-3 mb-lg-0" placeholder="Address" value="{{ old('address')? old('address') : $employee->address }}" />
                                            @error('address')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 mb-2">Department</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="department" data-control="select2" data-placeholder="Select Department" data-hide-search="true">
                                                <option></option>
                                                <?php
                                                if($departments->count()>0){
                                                    foreach($departments as $department){
                                                        $depID = old('department') ? old('department'): $employee->department;
                                                    ?>
                                                        <option value="{{ $department->id }}" {{ $department->id ==  $depID ? 'selected' : '' }}>{{ $department->name }}</option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            @error('department')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 mb-2">Designation</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="designation" data-control="select2" data-placeholder="Select Designation" data-hide-search="true">
                                                <option></option>
                                                <?php
                                                if($designations->count()>0){
                                                    foreach($designations as $designation){
                                                        $desID = old('designation') ? old('designation'): $employee->designation;
                                                    ?>
                                                        <option value="{{ $designation->id }}" {{ $designation->id == $desID ? 'selected' : '' }}>{{ $designation->name }}</option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            @error('designation')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col fv-row mt-5">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url('{{ $employee->image ? asset($employee->image) : asset('/assets/media/avatars/blank.png') }}')">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"></div>
                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Upload Image">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" value={{ $employee->image ? asset($employee->image) : asset('/assets/media/avatars/blank.png') }}/>
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->
                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="cancel"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Cancel button-->

                                                <!--begin::Remove button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="remove"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Remove button-->
                                            </div>
                                            @error('image')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5"  onClick="this.form.submit(); this.disabled=true; this.innerText='Wait...'; ">
                                        <!--begin::Indicator-->
                                        <span class="indicator-label">Update</span>
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

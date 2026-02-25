@extends('layouts.owner.app')
@section('title', 'Members Application')

{{-- Content --}}
@section('content')
        <div class="content-page">
            <div class="container-fluid">                  
                <div class="row mt-3">
                    <div class="col-12">
                        {{-- TABLE --}}
                        <div data-table data-table-rows-per-page="5" class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Members Application</h4>
                            </div>

                            <div class="card-header border-light justify-content-between">
                                <div class="d-flex gap-2">
                                    <div class="app-search">
                                        <input data-table-search type="search" class="form-control" placeholder="Search...">
                                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                                    </div>
                                    <button class="btn btn-danger d-none">Delete</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                    <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                        <tr class="text-uppercase fs-xxs">
                                            <th class="ps-3" style="width: 1%;">
                                                <input data-table-select-all class="form-check-input form-check-input-light fs-14 mt-0" type="checkbox" value="option">
                                            </th>
                                            <th data-table-sort>Fullname</th>
                                            <th data-table-sort>Email Address</th>
                                            <th data-table-sort>Contact Number</th>
                                            <th data-table-sort>Role</th>
                                            <th data-table-sort>Status</th>
                                            <th data-table-sort>Date Joined</th>
                                            <th class="text-center" style="width: 1%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-3">
                                                <input class="form-check-input form-check-input-light fs-14 product-item-check mt-0" type="checkbox" value="option">
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="avatar-lg me-1">
                                                        <img src="{{ asset('assets/images/products/1.png') }}" alt="Product" class="img-fluid rounded">
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="" class="link-reset">Ronan Bender</a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">UUID:</span>
                                                            <span class="text-muted">d3e26d71-ffb1-4f29-b3b7-b480f1e55c82</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>delacruz.justine@gmail.com</td>
                                            <td>+(63) 423 336 9884</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="" class="link-reset">Photographer</a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">Freelancer</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-soft-warning fs-8 px-1 w-100">PENDING</span></td>
                                            <td>April 26, 2026</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="#" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#memberModal"><i class="ti ti-eye fs-lg"></i></a>
                                                    <a href="#" class="btn btn-sm"><i class="ti ti-edit fs-lg"></i></a>
                                                    <a href="#" class="btn btn-sm"><i class="ti ti-trash fs-lg"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                            
                            <div class="card-footer border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div data-table-pagination-info="users"></div>
                                    <div data-table-pagination></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold" id="mymemberModalLabel">
                            User Profile
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            {{-- Left Side: Profile Image --}}
                            <div class="col-md-4 col-lg-3">
                                <div class="text-center">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="avatar" 
                                            class="rounded-circle border border-4 border-white shadow-sm" width="150" height="150">
                                        <span class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle p-1">
                                            <span class="visually-hidden">Online</span>
                                        </span>
                                    </div>
                                    <h4 class="mb-1 fw-semibold">John Alexander</h4>
                                    <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                                        <span class="badge badge-soft-primary fw-semibold px-2 fs-6">Photographer | Freelancer</span>
                                    </div>

                                    <hr class="my-3 border-dashed">
                                    
                                    {{-- Statistics Section --}}
                                    <div class="mt-2">
                                        <h6 class="mb-3 fw-semibold text-uppercase small text-primary">Activity Summary</h6>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light-primary rounded-3">
                                                    <h5 class="mb-0 fw-bold text-primary">5</h5>
                                                    <p class="small text-muted mb-0">Successful Bookings</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light-success rounded-3">
                                                    <h5 class="mb-0 fw-bold text-success">12</h5>
                                                    <p class="small text-muted mb-0">Bookings</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: User Details --}}
                            <div class="col-md-8 col-lg-9">
                                <div class="card border-0 shadow-none">
                                    <div class="card-body p-0">
                                        {{-- Personal Information Header --}}
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h6 class="card-title mb-0 fw-semibold text-uppercase small text-primary">
                                                Personal Information
                                            </h6>
                                            <div class="text-muted small">
                                                Member since: January 15, 2024
                                            </div>
                                        </div>
                                        
                                        <div class="row g-3">
                                            {{-- Full Name --}}
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="circle-user-round" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Full Name</label>
                                                        <p class="mb-0 fw-medium">John Alexander</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Email --}}
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="mail" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Email Address</label>
                                                        <p class="mb-0 fw-medium">john.alexander@example.com</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- UUID --}}
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="key-round" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">UUID</label>
                                                        <p class="mb-0 fw-medium text-truncate">d3e26d71-ffb1-4f29-b3b7-b480f1e55c82</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Mobile Number --}}
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="phone" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Mobile Number</label>
                                                        <p class="mb-0 fw-medium">+(63) 912 345 6789</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Account Status --}}
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="shield-check" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Account Status</label>
                                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                                            <span class="badge badge-soft-success px-2 fw-medium">Verified</span>
                                                            <span class="text-muted small">Email verified on Jan 15, 2024</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="mail-warning" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Invitation Status</label>
                                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                                            <p class="mb-0 fw-medium text-warning">Waiting for Owner Approval</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Additional Information Section (Optional) --}}
                                <div class="card border-0 shadow-none mt-4">
                                    <div class="card-body p-0">
                                        <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                            Additional Information
                                        </h6>
                                        {{-- You can add more user details here --}}
                                        <div class="row g-3">
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="map-pin" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Location</label>
                                                        <p class="mb-0 fw-medium">Manila, Philippines</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

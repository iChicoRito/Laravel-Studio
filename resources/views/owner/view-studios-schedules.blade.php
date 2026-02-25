@extends('layouts.owner.app')
@section('title', 'View Studios Schedules')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="5" class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Studios Schedules</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search schedules...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select data-table-filter="studio" class="me-0 form-select form-control">
                                    <option value="">All Studios</option>
                                        @php
                                            $uniqueStudios = [];
                                            foreach($schedules as $schedule) {
                                                if ($schedule->studio && !empty($schedule->studio->studio_name)) {
                                                    $uniqueStudios[$schedule->studio_id] = $schedule->studio->studio_name;
                                                }
                                            }
                                            asort($uniqueStudios);
                                        @endphp
                                        @foreach($uniqueStudios as $studioId => $studioName)
                                            <option value="{{ $studioName }}">{{ $studioName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort data-column="studio">Studio</th>
                                        <th data-table-sort>Operating Days</th>
                                        <th data-table-sort>Operating Hours</th>
                                        <th data-table-sort>Booking Limits</th>
                                        <th data-table-sort>Advance Booking</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->studio->studio_name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->formatted_operating_days }}</td>
                                        <td>{{ $schedule->formatted_operating_hours }}</td>
                                        <td>{{ $schedule->booking_limit }} Bookings per day</td>
                                        <td>{{ $schedule->advance_booking }} Day(s)</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editScheduleModal{{ $schedule->id }}">
                                                    <i class="ti ti-edit fs-lg"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="{{ $schedule->id }}">
                                                    <i class="ti ti-trash fs-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="schedules"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // Delete schedule
            $(document).on('click', '.btn-delete', function() {
                const scheduleId = $(this).data('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6C757D',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/owner/delete/studio-schedules/${scheduleId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        confirmButtonColor: '#007BFF',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Failed to delete schedule.',
                                    confirmButtonColor: '#DC3545'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
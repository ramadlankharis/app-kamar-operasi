@extends('layouts.dashboard-admin')

@section('title', 'Update Status Ruangan')

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .room-select .room-select-option:disabled {
            background-color: #f8d7da;
            /* color: #721c24; */
        }

        .btn-back {}

        .btn-submit {
            margin-left: auto;
        }
    </style>
@endpush

@section('content')
    <div class="row m-t-25 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">


                <!-- Card Header dengan gradient -->
                <div class="card-header bg-gradient-primary py-3">
                    <h5 class="mb-0 text-white ">
                        <i class="fas fa-door-open mr-2"></i>
                        Pilih Operator
                    </h5>
                </div>


                <div class="card-body bg-light">
                    <div class="card-title mb-4">
                        <h3 class="text-center title-2 text-primary">
                            Update Status Ruangan
                        </h3>
                    </div>

                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="form-group">
                            <label for="selectLg" class="control-label mb-2 text-primary">
                                <i class="fas fa-building mr-1"></i>
                                Pilih Operator Untuk Ruangan {{ $room->nama_ruangan }}
                            </label>
                            <select name="selectLg" id="selectOperator"
                                class="room-select form-control-lg form-control border-primary rounded-lg shadow-sm required">
                                <option value="" disabled selected>
                                    -- Silakan Pilih Operator --
                                </option>
                                @foreach ($operators as $item)
                                    <option class="room-select-option" value="{{ $item->id }}"
                                        @if (!$item->is_available) disabled @endif>
                                        {{ $item->nama }} {{ $item->is_available ? '' : '(Tidak Aktif)' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Pilih operator untuk lanjut memperbarui status ruangan
                            </small>
                        </div>

                        <!-- Button dengan hover effect -->
                        <div class="mt-4 d-flex ">
                            <button id="backBtn"
                                class="btn btn-lg btn-danger rounded-pill shadow transition-all hover:shadow-lg btn-back">
                                <i class="fa fa-arrow-left fa-lg"></i>&nbsp;
                                Back
                            </button>
                            <button id="submitBtn"
                                class="btn btn-lg btn-primary rounded-pill shadow transition-all hover:shadow-lg btn-submit">
                                <i class="fa fa-arrow-right fa-lg"></i>&nbsp;
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center text-muted py-3">
                    <small>
                        <i class="fas fa-clock mr-1"></i>
                        Status ruangan terakhir diperbarui: <span id="lastUpdate">Hari ini</span>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#backBtn').click(function(e) {
                e.preventDefault();
                let url = "{{ route('index.pilih.ruangan.ok') }}"; // Template URL
                window.location.href = url;
            });

            $('#submitBtn').click(function(e) {
                e.preventDefault();

                const selectedRoom = {{ $room->id }};
                // Check if an operator is selected
                const selectedOperator = $('#selectOperator').val();

                if (!selectedOperator) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Silakan pilih operator terlebih dahulu',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    });
                    return false;
                }
                console.log(selectedOperator);

                let updateUrl = '{{ route('admin.monitoring.ajax.operator', ':id') }}';
                updateUrl = updateUrl.replace(':id', selectedRoom);

                $.ajax({
                    url: updateUrl,
                    type: 'PUT',
                    data: {
                        operator_id: selectedOperator,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Template URL
                            let url = "{{ route('admin.monitoring.edit', ':value') }}";
                            url = url.replace(':value', selectedRoom); // replace selected
                            window.location.href = url;
                        } else {
                            Swal.fire({
                                title: 'Peringatan!',
                                text: `Gagal memperbarui operator ${response.error ?? response.error}`,
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani berbagai kemungkinan error
                        let errorMessage = 'Terjadi kesalahan';

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        } else if (xhr.status === 404) {
                            errorMessage = 'Status tidak ditemukan';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan server';
                        }

                        console.error('Ajax Error:', {
                            status: xhr.status,
                            error: error,
                            response: xhr.responseJSON
                        });

                        Swal.fire({
                            title: 'Peringatan!',
                            text: errorMessage,
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                });
            });
        });
    </script>
@endpush

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

        .select-option-disabled {
            background-color: #f8d7da;
            /* color: #721c24; */
        }

        .btn-back {}

        .btn-submit {
            margin-left: auto;
        }

        .dropdown {}

        .dropdown-menu {
            max-height: 13rem;
            overflow-y: scroll;
            width: 100%;
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
                        Update Status Ruangan
                    </h5>
                </div>


                <div class="card-body bg-light">
                    <div class="card-title mb-4">
                        <h3 class="text-center title-2 text-primary">
                            Pilih Operator
                        </h3>
                    </div>

                    <div class="form-group">
                        <label for="selectLg" class="control-label mb-2 text-primary">
                            <i class="fas fa-building mr-1"></i>
                            Pilih Operator Untuk Ruangan {{ $room->nama_ruangan }}
                        </label>
                        <div class="dropdown" name="selectLg">
                            <button
                                class="btn btn-lg dropdown-toggle room-select form-control-lg form-control border-primary rounded-lg shadow-sm required"
                                type="button" id="chosenOperator" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                -- Silakan Pilih Operator --
                            </button>
                            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="chosenOperator">
                                <form class="px-4 py-2">
                                    <input type="search" class="form-control" id="searchOperator"
                                        placeholder="Cari operator..." autofocus="autofocus">
                                </form>
                                <div id="menuItems" class="room-select-option"></div>
                                <div id="empty" class="dropdown-header">
                                    Operator tidak ditemukan
                                </div>
                            </div>
                        </div>

                        {{-- <select name="selectLg" id="selectOperator"
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
                        </select> --}}

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
        const lastUpdated = '{{ $room->updated_at->locale('id')->diffForHumans() }}';
        $('#lastUpdate').text(lastUpdated);
    </script>
@endpush
@push('scripts')
    <script>
        // Find the input search box;
        const searchEl = document.getElementById("searchOperator");
        // Find every item inside the dropdown
        const itemsEl = document.getElementsByClassName("dropdown-item");
        const dropDownEl = document.getElementById("dropdownMenu");

        let scrollOperators = [];
        let searchOperators = [];
        let currentSelectedOperatorId = null;

        function buildDropDown(values) {
            let contents = []
            for (let op of values) {
                const name = op.is_available ? op.nama : `${op.nama} (Tidak Aktif)`;

                contents.push(
                    `<input type="button" id="${op.id}"  class="dropdown-item ${op.is_available ? "" : "select-option-disabled" }" ${op.is_available ? "" : "disabled"}   type="button" value="${name}"/>`
                )
            }
            $('#menuItems').append(contents.join(""))

            // Hide the row that shows no items were found
            $('#empty').hide()

            if (values.length === 0) {
                $('#empty').show()
            }
        }

        const fetchInitial = async () => {
            $.ajax({
                url: '{{ route('admin.monitoring.ajax.fetch.operator') }}',
                type: 'GET',
                data: {
                    from_scroll: true,
                    page: 1,
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        scrollOperators = response.data;
                        buildDropDown(scrollOperators.data);
                    } else {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: `Gagal memuat data operator ${response.error ?? ""}`,
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Tangani berbagai kemungkinan error
                    let errorMessage = 'Terjadi kesalahan fetching initial data';

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
        }

        //For every word entered by the user, check if the symbol starts with that word
        //If it does show the symbol, else hide it
        function filter(word) {
            if(word.length === 0) {
                $('#menuItems').empty();
                buildDropDown(scrollOperators.data);
                return;
            }

            $.ajax({
                url: '{{ route('admin.monitoring.ajax.fetch.operator') }}',
                type: 'GET',
                data: {
                    search: word,
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        searchOperators = response.data;
                        $('#menuItems').empty();
                        buildDropDown(searchOperators);
                    } else {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: `Gagal memuat data operator ${response.error ?? ""}`,
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Tangani berbagai kemungkinan error
                    let errorMessage = 'Terjadi kesalahan mencari data';

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
        }

        //Capture the event when user types into the search box
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        const debouncedFilter = debounce(function() {
            filter(searchEl.value.trim().toLowerCase());
        }, 150);
        searchEl.addEventListener('input', debouncedFilter);

        //If the user clicks on any item, set the title of the button as the text of the item
        $('#menuItems').on('click', '.dropdown-item', function() {
            // verify if the operator is disabled
            const selectedValue = $(this)[0].value;
            const selectedId = $(this)[0].id;
            const isDisabled = $(this).hasClass('select-option-disabled');
            if (isDisabled) return;

            currentSelectedOperatorId = selectedId;
            $('#chosenOperator').text($(this)[0].value)
            $("#chosenOperator").dropdown('toggle');
        })

        dropDownEl.addEventListener('scroll', event => {
            const {
                scrollHeight,
                scrollTop,
                clientHeight
            } = event.target;

            // if search is active dont do anything / dont paginate
            if (searchEl.value.trim().length > 0) return;

            if (Math.abs(scrollHeight - clientHeight - scrollTop) < 1) {
                if (!scrollOperators.next_page_url) return;

                $.ajax({
                    url: scrollOperators.next_page_url,
                    data: {
                        from_scroll: true,
                        page: scrollOperators.current_page + 1,
                    },
                    type: 'GET',
                    success: function(response) {
                        // console.log(response);

                        if (response.success) {
                            // the operator data is nested inside data because it is paginated and we name the data key as data
                            const { data: opData } = response.data;
                            const currentOpData = scrollOperators.data.concat(opData);
                            response.data.data = currentOpData;

                            scrollOperators = response.data;
                            buildDropDown(opData);
                        } else {
                            Swal.fire({
                                title: 'Peringatan!',
                                text: `Gagal memuat data operator ${response.error ?? ""}`,
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani berbagai kemungkinan error
                        let errorMessage = 'Terjadi kesalahan fetching initial data';

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
            }
        });

        $('#backBtn').click(function(e) {
            e.preventDefault();
            let url = "{{ route('index.pilih.ruangan.ok') }}"; // Template URL
            window.location.href = url;
        });

        $('#submitBtn').click(function(e) {
            e.preventDefault();

            const selectedRoom = {{ $room->id }};

            // Check if an operator is selected
            if (!currentSelectedOperatorId) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Silakan pilih operator terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }
            console.log(currentSelectedOperatorId);

            let updateUrl = '{{ route('admin.monitoring.ajax.operator', ':id') }}';
            updateUrl = updateUrl.replace(':id', selectedRoom);

            $.ajax({
                url: updateUrl,
                type: 'PUT',
                data: {
                    operator_id: currentSelectedOperatorId,
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

        fetchInitial();
    </script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush

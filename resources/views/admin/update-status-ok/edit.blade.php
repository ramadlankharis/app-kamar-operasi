@extends('layouts.dashboard-admin')

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}
/* Custom button styles */
.back-btn {
    background: linear-gradient(45deg, #3498db, #2980b9);
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: linear-gradient(45deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    color: white;
}

.next-btn {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    transition: all 0.3s ease;
}

.next-btn:hover {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
    color: white;
}

/* Optional: Add active state effect */
.back-btn:active, .next-btn:active {
    transform: translateY(1px);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

/* Optional: Add disabled state styles */
.back-btn:disabled, .next-btn:disabled {
    background: #cccccc;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

/* Optional: Add loading state */
.btn-loading {
    opacity: 0.8;
    cursor: wait;
}

/* Additional hover effect for icons */
.btn i {
    transition: transform 0.3s ease;
}

.back-btn:hover i {
    transform: translateX(-3px);
}

.next-btn:hover i {
    transform: translateX(3px);
}

/* Status Title Styling */
.status-title {
    font-size: 2.5rem; /* text-3xl equivalent */
    font-weight: 700; /* font-bold equivalent */
    text-align: center;
    background: linear-gradient(45deg, #4834d4, #686de0);
    /* background: linear-gradient(45deg, #6c5ce7, #a55eea); */
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: 1px;
    margin: 1rem 0;
    padding: 0.5rem;
    position: relative;
    animation: titleAppear 0.5s ease-out;
}

.status-title:hover {
    transform: scale(1.05);
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
}

/* Optional: Add animation */
@keyframes titleAppear {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Optional: Add a subtle border effect */
.status-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: linear-gradient(45deg, #4834d4, #686de0);
    border-radius: 2px;
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
                <div class="card-title space-y-6">
                    <!-- Title Section -->
                    <div class="text-center space-y-4">
                        <h1 class="text-center title-1 text-primary">
                            {{ $namaRuangan }}
                        </h1>
                    </div>
                </div>
            
                <div class="p-4 bg-white rounded shadow-sm">
                    <div>
                        {{-- <h1 class="text-3xl font-bold text-center text-secondary">
                            {{$titleCaseStatusKamar}}
                        </h1> --}}
                        <h1 class="status-title" id="responseMessage">
                            {{$titleCaseStatusKamar}}
                        </h1>
                    </div>
            
                    <!-- Button dengan hover effect -->
                    <div class="mt-5">
                        <div class="d-flex justify-content-between px-4">
                            <button class="btn back-btn" id="backStep">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back
                            </button>
                            <button class="btn next-btn" id="nextStep">
                                Next
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    function toTitleCase(str) {
        return str
        .toLowerCase()  // Ubah semua huruf menjadi huruf kecil terlebih dahulu
        .split(' ')     // Pisahkan string berdasarkan spasi
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Ubah huruf pertama menjadi besar
        .join(' ');     // Gabungkan kembali menjadi string dengan spasi
    }
    
    $('#backStep').click(function() {
        let id = '{{ $kamar->id }}'; 
        var updateUrl = '{{ route("admin.monitoring.ajax.back.step", ":id") }}';
        let ajaxUrl = updateUrl.replace(':id', id);
        $.ajax({
            url: ajaxUrl, 
            type: 'PUT',
            data: {
                step: 'back', 
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                $('#responseMessage').text(toTitleCase(response.message));
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
                $('#responseMessage').text('Error: ' + error);
            }
        });
    });

    // Fungsi AJAX untuk tombol "Next Step"
    $('#nextStep').click(function() {
        let id = '{{ $kamar->id }}'; // ID kamar yang diambil dari backend
        var updateUrl = '{{ route("admin.monitoring.ajax.next.step", ":id") }}'; // ":id" sebagai placeholder
            // Ganti placeholder :id dengan nilai dinamis dari variabel id
        let ajaxUrl = updateUrl.replace(':id', id);
        $.ajax({
            url: ajaxUrl,
            type: 'PUT',
            data: {
                step: 'next',
                _token: '{{ csrf_token() }}' // Laravel CSRF token
            },
            success: function(response) {
                $('#responseMessage').text(toTitleCase(response.message));
                // console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error)
                $('#responseMessage').text('Error: ' + error);
            }
        });
    });
})
</script>
@endpush
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

.status-container {
    margin-bottom: 2rem;
    position: relative;
    padding: 20px 0;
}

.progress-line {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    width: 100%;
    height: 4px;
    background: #e2e8f0;
    z-index: 1;
}

.progress-line-fill {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: #10b981;
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.steps {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    transition: transform 0.3s ease;
}

.step:hover {
    transform: translateY(-2px);
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #64748b;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.step-circle.active {
    background: #3b82f6;
    color: white;
    animation: pulse 2s infinite;
}

.step-circle.completed {
    background: #10b981;
    color: white;
    animation: completedPop 0.5s ease;
}

.step-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
    text-align: center;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.step.active .step-label {
    color: #3b82f6;
    font-weight: 600;
    animation: fadeInUp 0.5s ease;
}

.step.completed .step-label {
    color: #10b981;
    font-weight: 600;
}

.navigation {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 2rem;
}

.step-info {
    text-align: center;
    margin: 1.5rem 0;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    color: #475569;
    animation: fadeIn 0.5s ease;
}

.checkmark {
    display: none;
    color: white;
}

.step-circle.completed .checkmark {
    display: inline;
    animation: scaleIn 0.4s ease;
}

.step-circle.completed .step-number {
    display: none;
}

/* Tooltip improvements */
.step-circle::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: -45px;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: #1e293b;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    white-space: nowrap;
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.step-circle:hover::before {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

/* Enhanced Animations */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
    }
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
    }
    70% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes completedPop {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

/* Responsive styles */
@media (max-width: 640px) {
    .container {
        padding: 1rem;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }

    .step-label {
        font-size: 0.75rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }
}

.time-estimate {
    font-size: 0.875rem;
    color: #64748b;
    text-align: center;
    margin-top: 0.5rem;
    animation: fadeIn 0.5s ease;
}
</style>
@endpush

@section('content')
<div class="row m-t-25 justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-lg">
            <!-- Card Header dengan gradient -->
            <div class="card-header bg-gradient-primary py-3">
                <h5 class="mb-0 text-white float-left ">
                    <i class="fas fa-door-open mr-2"></i>
                    Update Status Ruangan
                </h5>
                <h5 class="mb-0 text-white float-right" id="tanggal-hari">
                    <i class="fas fa-door-open mr-2"></i>
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
                    {{-- <div>
                        <h1 class="status-title" id="responseMessage">
                            {{$titleCaseStatusKamar}}
                        </h1>
                    </div> --}}
                    <div class="status-container">
                        <div class="progress-line">
                            <div class="progress-line-fill" id="progressLine"></div>
                        </div>
                        
                        <div class="steps" id="stepsContainer">
                            <!-- Steps will be generated by JavaScript -->
                        </div>
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

    const sequences = @json($sequences);

    const steps = sequences.map(sequence => ({
        id: sequence.squence_status_operasi,
        label: sequence.status_operasi,
        tooltip: sequence.status_operasi // Anda bisa menambahkan field tooltip di model jika diperlukan
    }));

    let currentStep = {{ $kamar->squence_status_operasi }} - 1; // Sesuaikan dengan status operasi saat ini

        
        function createSteps() {
            const container = document.getElementById('stepsContainer');
            container.innerHTML = ''; // Bersihkan container sebelum menambahkan steps baru
            
            steps.forEach((step, index) => {
                const stepElement = document.createElement('div');
                stepElement.className = `step ${index === currentStep ? 'active' : ''} ${index < currentStep ? 'completed' : ''}`;
                
                stepElement.innerHTML = `
                    <div class="step-circle" data-tooltip="${step.tooltip}">
                        <span class="step-number">${step.id}</span>
                        <span class="checkmark">✓</span>
                    </div>
                    <div class="step-label">${step.label}</div>
                `;
                
                container.appendChild(stepElement);
            });
        }

         // Initialize the UI
         function initializeUI() {
            createSteps();
            updateProgress();
        }

        // Update all UI elements
        function updateUI() {
        const stepElements = document.querySelectorAll('.step');
        
        stepElements.forEach((element, index) => {
            element.className = `step ${index === currentStep ? 'active' : ''} ${index < currentStep ? 'completed' : ''}`;
        });
        
        updateProgress();
        }

        // Update progress line
        function updateProgress() {
            const progressLine = document.getElementById('progressLine');
            const progress = (currentStep / (steps.length - 1)) * 100;
            progressLine.style.width = `${progress}%`;
        }

        // Initialize the UI when the page loads
        initializeUI();

    // function toTitleCase(str) {
    //     return str
    //     .toLowerCase()  // Ubah semua huruf menjadi huruf kecil terlebih dahulu
    //     .split(' ')     // Pisahkan string berdasarkan spasi
    //     .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Ubah huruf pertama menjadi besar
    //     .join(' ');     // Gabungkan kembali menjadi string dengan spasi
    // }
    
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
                // $('#responseMessage').text(toTitleCase(response.message));
                currentStep = response.sequence - 1;
                updateUI();
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

                $('#responseMessage')
                    .text('Error: ' + errorMessage);
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
                 // $('#responseMessage').text(toTitleCase(response.message));
                currentStep = response.sequence - 1;
                updateUI();
                // console.log(response.sequence - 1);
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

                $('#responseMessage')
                    .text('Error: ' + errorMessage);
            }
        });
    });

    function updateClock() {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const formattedTime = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        document.getElementById('tanggal-hari').innerHTML = formattedTime;
    }

    // Update setiap detik
    setInterval(updateClock, 1000);
    // Panggil sekali untuk menghindari delay 1 detik pertama
    updateClock();
})
</script>
@endpush
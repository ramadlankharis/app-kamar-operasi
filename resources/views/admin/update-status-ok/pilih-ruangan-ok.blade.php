@extends('layouts.dashboard-admin')

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
                    Pilih Ruangan
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
                                Pilih Ruangan
                            </label>
                            <select name="selectLg" id="selectRuangan" 
                                class="form-control-lg form-control border-primary rounded-lg shadow-sm required">
                                <option value="" disabled selected>
                                    -- Silakan Pilih Ruangan --
                                </option>
                                @foreach ($datas as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Pilih ruangan untuk memperbarui statusnya
                            </small>
                        </div>

                        <!-- Button dengan hover effect -->
                        <div class="mt-4">
                            <a href="#" id="submitBtn" type="submit" 
                                class="btn btn-lg btn-primary btn-block rounded-pill shadow transition-all hover:shadow-lg">
                                <i class="fa fa-check fa-lg"></i>&nbsp;
                                Submit
                            </a>
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

    var value = 0;

    $('#submitBtn').click(function(e) {
        e.preventDefault();
        
        // Check if a room is selected
        const selectedRoom = $('#selectRuangan').val();
        
        if (!selectedRoom) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Silakan pilih ruangan terlebih dahulu',
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        
        // If room is selected, you can proceed with form submission
        // Add your form submission logic here

        $('#selectRuangan').val('').trigger('change');
        var url = "{{ route('admin.monitoring.edit', ':value') }}"; // Template URL
        url = url.replace(':value', selectedRoom); // Mengganti placeholder ':value' dengan nilai yang dipilih
        window.location.href = url;
        
    });
});
</script>
@endpush
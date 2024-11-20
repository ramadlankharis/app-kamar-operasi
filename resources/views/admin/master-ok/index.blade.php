{{-- resources/views/admin/master-ok/index.blade.php --}}

@extends('layouts.dashboard-admin')

@section('title', 'Master OK')

@push('styles')
<style>
    .bg-gradient-primary {
        /* background: linear-gradient(45deg, #0300b9, #379ff5); */
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    .bg-danger-custom {
        background: linear-gradient(45deg, #1C9B8E, #1B3A53); /* Ganti dengan warna yang diinginkan */
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
    .badges {
  display: flex;
  flex-direction: column;
  gap: 1rem; /* 16px */
  align-items: center;
  flex-wrap: wrap;
  justify-content: center;
    }

    .badges > button {
  font-size: 0.875rem; /* 14px */
  line-height: 1.25rem; /* 20px */
  padding: 2px .5rem; /* 8px*/
  cursor: pointer;
  border: none;
  border-radius: 0.375rem; /* 6px */
  outline: none;
    }
    .badges .blue {
  background-color: rgb(59, 130, 246, 0.10);
  color: rgb(59 130 246);
  border: 1px rgb(59 130 246) solid;
    }
    .badges .red {
  background-color: rgba(239, 68, 68, 0.10);
  color: rgb(239 68 68);
  border: 1px rgb(239 68 68) solid;
}
    
   
</style>
@endpush

@section('content')
<div class="row m-t-25 justify-content-center">
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-danger-custom py-3"> <!-- Ganti kelas di sini -->
                <h5 class="mb-0 text-white">
                    <i class="fas fa-door-open mr-2"></i>
                    Data Master OK
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div id="success-message" class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Ruangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataOk as $key => $item)
                                    <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->nama_ruangan }}</td>
                                    <td>
                                        @if ( $item->is_active === true)
                                        <div class="badges">
                                            <button class="blue">aktif</button>
                                   
                                    @else
                                    <div class="badges">
                                    <button class="red">tidak aktif</button>
                                    @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.master-ok.edit', $item->id) }}" 
                                           class="next-btn btn-sm">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 1s';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 1000);
            }, 3000);
        }
    });
</script>
@endpush
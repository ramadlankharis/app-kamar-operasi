{{-- resources/views/admin/master-ok/edit.blade.php --}}
@extends('layouts.dashboard-admin')

@section('title', 'Add Status Operasi')

@push('styles')
<style>
.bg-gradient-primary {
        background: linear-gradient(45deg, #1C9B8E, #1B3A53);
    }
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
    text-decoration: none; /* Menghilangkan garis bawah pada link */
}

.back-btn:hover {
    background: linear-gradient(45deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    color: white;
}

.next-btn {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    transition: all 0.3s ease;
    cursor: pointer; /* Menunjukkan bahwa ini adalah tombol yang dapat diklik */
}

.next-btn:hover {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
    color: white;
}
</style>
@endpush

@section('content')
<div class="row m-t-25 justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-gradient-primary py-3">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-door-open mr-2"></i>
                    Add Operator
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.master-operator.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="nama_operator">Nama Operator</label>
                        <input type="text"
                               class="form-control @error('nama_operator') is-invalid @enderror"
                               id="nama_operator"
                               name="nama_operator"
                               required>
                        @error('nama_operator')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group d-flex justify-content-end">
                        <a href="{{ route('admin.master-operator.index') }}" class="back-btn mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="next-btn">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>


                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush

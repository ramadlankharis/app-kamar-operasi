{{-- resources/views/admin/master-status-operasi/index.blade.php --}}
@extends('layouts.dashboard-admin')

@section('title', 'Master Status Operasi')

@push('styles')
<style>
.bg-gradient-primary {
/* background: linear-gradient(45deg, #0300b9, #379ff5); */
    background: linear-gradient(45deg,  #4e73df, #224abe);
}
.bg-danger-custom {
    background: linear-gradient(45deg, #1C9B8E, #1B3A53); /* Ganti dengan warna yang diinginkan */
}
/* Custom button styles */
.add-btn {
    background: linear-gradient(45deg, #3498db, #2980b9);
    color: white;
    padding: 5px 15px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    text-decoration: none;
}

.add-btn:hover {
    background: linear-gradient(45deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    color: white;
}

.add-btn svg {
    width: 16px;
    height: 16px;
    transition: transform 0.3s ease;
}



.reorder-btn {
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

.reorder-btn:hover {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
    color: white;
}

.search-btn {
    background: linear-gradient(45deg, #ffce07, #f58020);
    color: white;
    padding: 5px 15px;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: linear-gradient(45deg, #f58020, #ffce07);
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
.delete-btn {
    background: linear-gradient(45deg, #f83131, #fa3535);
    color: white;
    padding: 8px 20px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0,5px;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    text-decoration: none;
}

.delete-btn:hover {
    background: linear-gradient(45deg, #ae2727, #f04040);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
    color: white;
}
.delete-btn svg {
    width: 16px;
    height: 16px;
    transition: transform 0.3s ease;
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
                    Data Master Operator
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div id="success-message" class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('danger'))
                <div id="danger-message" class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        {{-- <a href="{{ route('admin.master-status-operasi.reorder.index') }}" class="reorder-btn btn-sm mr-2">  ☰ Edit Urutan</a> --}}
                        <form action="{{ route('admin.master-operator.search') }}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" name="cari_operator" class="form-control" placeholder="Cari operator" aria-label="Cari operator" aria-describedby="basic-addon2">
                                <div class="input-group-append ml-1">
                                    <button class="btn search-btn" type="submit">
                                        <i class="fas fa-search mr-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('admin.master-operator.create') }}" class="add-btn">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 6C13 5.44771 12.5523 5 12 5C11.4477 5 11 5.44771 11 6V11H6C5.44771 11 5 11.4477 5 12C5 12.5523 5.44771 13 6 13H11V18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18V13H18C18.5523 13 19 12.5523 19 12C19 11.4477 18.5523 11 18 11H13V6Z" fill="#ffffff"/>
                                </g>
                            </svg>
                            Add
                        </a>
                    </div>
                </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-gradient-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            @foreach($dataOperator as $key => $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        @if ( $item->is_available === true)
                                            <div class="badges">
                                            <button class="blue">aktif</button>
                                        @else
                                            <div class="badges">
                                            <button class="red">tidak aktif</button>
                                        @endif
                                    </td>
                                    <td>
                                            <a href="{{ route('admin.master-operator.edit', $item->id) }}" class="reorder-btn btn-sm">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <a href="" class="delete-btn btn-sm" data-id="{{$item->id}}">
                                                <svg fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"></path></g></svg>
                                                Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        <div class="mt-5">
                            <div class="d-flex justify-content-between px-4">
                                <p>Menampilkan {{ $dataOperator->firstItem() }} sampai {{ $dataOperator->lastItem() }} dari {{ $dataOperator->total() }} data</p>
                                <nav aria-label="Page navigation example">
                                    {{ $dataOperator->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
document.addEventListener('DOMContentLoaded', function() {
    var successMessage = document.getElementById('danger-message');
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
function toTitleCase(str) {
    return str
        .toLowerCase()
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
}

// Ambil semua elemen dengan kelas 'status-text'
const statusElements = document.querySelectorAll('.status-text');

// Ubah teks untuk setiap elemen
statusElements.forEach(element => {
    const status = element.getAttribute('data-status'); // Ambil status dari atribut data
    element.textContent = toTitleCase(status); // Ubah teks menjadi title case
});

$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Data operator akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.master-operator.index') }}" + '/' + id ,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            timer: 20000,
                            timerProgressBar: true,
                            title: "Deleted!",
                            text: JSON.stringify(response.message),
                            // text: response.message,
                            icon: "success",
                            willClose: () => {
                                location.reload();
                            }
                        });
                    },
                        error: function(response) {

                            Swal.fire({
                                timer: 2000,
                                timerProgressBar: true,
                                icon: 'error',
                                title: 'Error',
                                // text: JSON.stringify(response.error),
                                text: response.responseJSON.error,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                            // alert(response.responseJSON.error);
                    }
                });

            }
        });
});
</script>
@endpush

{{-- resources/views/admin/master-status-operasi/index.blade.php --}}
@extends('layouts.dashboard-admin')

@push('styles')
<style>
.draggable-item {
    cursor: move;
    padding: 12px 16px;
    margin: 8px 0;
    background-color: #ffffff;
    border: 1px solid #e1e5ea;
    border-radius: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.draggable-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    border-color: #c0c6cc;
}

.draggable-item.dragging {
    opacity: 0.7;
    background-color: #f8fafc;
    border: 1px dashed #94a3b8;
}

.status-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    border-radius: 50%;
    margin-right: 12px;
    font-weight: 500;
    font-size: 0.9rem;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(45deg,  #4e73df, #224abe);
    /* background: linear-gradient(45deg, #1C9B8E, #1B3A53); */
    border-bottom: 1px solid #f1f5f9;
    padding: 1.25rem;
}

.card-header h3 {
    color: #1e293b;
    font-weight: 600;
    font-size: 1.25rem;
}

.card-body {
    padding: 1.5rem;
    background-color: #f8fafc;
}

.list-group-item {
    display: flex;
    align-items: center;
    color: #334155;
    font-weight: 500;
}
   
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-white">Status Operasi Manager Reorder</h3>
            </div>
            <div class="card-body">
                <div id="status-list" class="list-group">
                    @foreach($dataOk as $item)
                    <div class="draggable-item list-group-item" 
                         data-id="{{ $item->id }}" 
                         data-order="{{ $item->squence_status_operasi }}">
                        <span class="status-number">{{ $item->squence_status_operasi }}</span>
                        <span class="status-text" data-status="{{ $item->status_operasi }}">{{ $item->status_operasi }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Loading Overlay --}}
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    

    // document.addEventListener('DOMContentLoaded', function() {
    //     var successMessage = document.getElementById('success-message');
    //     if (successMessage) {
    //         setTimeout(function() {
    //             successMessage.style.transition = 'opacity 1s';
    //             successMessage.style.opacity = '0';
    //             setTimeout(function() {
    //                 successMessage.style.display = 'none';
    //             }, 1000);
    //         }, 3000);
    //     }
    // });
    // Setup CSRF token untuk semua Ajax requests
   

        // Inisialisasi Sortable
        document.addEventListener('DOMContentLoaded', function() {
            const statusList = document.getElementById('status-list');
            
            new Sortable(statusList, {
                animation: 150,
                ghostClass: 'dragging',
                onEnd: function(evt) {
                    const item = evt.item;
                    const id = item.dataset.id;
                    const newPosition = evt.newIndex + 1;

                    console.log(id);
                    console.log(newPosition);
                    

                    // Tampilkan loading overlay
                    $('#loading-overlay').show();

                    // Kirim request ke server
                    $.ajax({
                        url: '{{route("admin.master-status-operasi.update-order")}}',
                        method: 'POST',
                        data: {
                            id: id,
                            new_position: newPosition,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update nomor urutan
                                updateOrderNumbers();
                                // showAlert('success', 'Urutan berhasil diperbarui');
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Urutan berhasil diperbarui',
                                    icon: 'success',
                                    timer: 1000, // The alert will close after 1 seconds
                                    timerProgressBar: true, // Optional: show a progress bar
                                    willClose: () => {
                                        // Optional: execute code when the alert closes
                                        console.log('Alert closed');
                                    }
                                });

                                console.log(response.success);
                                
                            } else {
                                // showAlert('danger', 'Gagal mengubah urutan');
                                Swal.fire({
                                    title: "error!",
                                    text: 'Gagal mengubah urutan',
                                    // text: JSON.stringify(response.message, null, 2),
                                    icon: "error"
                                });
                                // Reload halaman jika gagal untuk mengembalikan ke urutan sebelumnya
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            // showAlert('danger', 'Terjadi kesalahan: ' + xhr.responseText);
                            location.reload();
                            Swal.fire({
                                    title: "danger!",
                                    text: 'Terjadi kesalahan: ' + xhr.responseText,
                                    // text: JSON.stringify(response.message, null, 2),
                                    icon: "error"
                                });
                            
                        },
                        complete: function() {
                            // Sembunyikan loading overlay
                            $('#loading-overlay').hide();
                        }
                    });
                }
            });
        });

        // Fungsi untuk mengupdate nomor urutan setelah drag & drop
        function updateOrderNumbers() {
            const items = document.querySelectorAll('.draggable-item');
            items.forEach((item, index) => {
                const statusNumber = item.querySelector('.status-number');
                statusNumber.textContent = index + 1;
                item.dataset.order = index + 1;
            });
        }
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

        // Fungsi untuk menampilkan alert
        // function showAlert(type, message) {
        //     const alertDiv = document.createElement('div');
        //     alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        //     alertDiv.innerHTML = `
        //         ${message}
        //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //     `;
            
        //     const container = document.querySelector('.card-body');
        //     container.insertBefore(alertDiv, container.firstChild);

        //     Hilangkan alert setelah 3 detik
        //     setTimeout(() => {
        //         alertDiv.remove();
        //     }, 3000);
        // }
</script>
@endpush
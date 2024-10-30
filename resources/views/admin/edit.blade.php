<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Ruangan</div>
    
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        <form action="{{ route('admin.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
    
                            <div class="mb-3">
                                <label for="urutan" class="form-label">Urutan</label>
                                <input type="text" name="urutan" class="form-control" id="urutan" 
                                       value="{{ old('urutan', $data->squence_status_operasi) }}" required>
                                @error('urutan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                                <input type="text" name="nama_ruangan" class="form-control" id="nama_ruangan"
                                       value="{{ old('nama_ruangan', $data->nama_ruangan) }}" required>
                                @error('nama_ruangan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <button type="submit" class="btn btn-primary">Update</button>
                            {{-- <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="btn btn-secondary">Cancel</a> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
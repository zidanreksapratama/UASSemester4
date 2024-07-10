@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="row align-items-center">
        <div class="col-sm-6 col-md-8">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body table-responsive">
            <div class="d-sm-flex align-items-center">
                    <button type="button" class="btn btn-primary mb-3 me-auto" data-bs-toggle="modal"
                        data-bs-target="#addAlternativeModal">
                        <i class="fas fa-plus me-1"></i>
                        Alternatif
                    </button>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-sm-flex align-items-center justify-content-between">
                <div class="d-sm-flex align-items-center mb-3">
                    <select class="form-select me-3" id="perPage" name="perPage" onchange="submitForm()">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form-label col-lg-7 col-sm-7 col-md-7" for="perPage">entries per page</label>
                </div>

                <form action="{{ route('alternatif.index') }}" method="GET" class="ms-auto float-end">
                    <div class="input-group mb-3">
                        <input type="text" name="search" id="myInput" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <table class="table table-bordered table-responsive">
                <thead class="table-primary align-middle">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Alternatif</th>
                        <th class="text-center" rowspan="2">Kelas</th>
                        <th class="text-center" colspan="{{ $criterias->count() }}">Kriteria</th>
                        
                            <th class="text-center" rowspan="2">Aksi</th>
                        
                    </tr>
                    <tr>
                        @if ($criterias->count())
                            @foreach ($criterias as $criteria)
                                <th class="text-center">{{ $criteria->name }}</th>
                            @endforeach
                        @else
                            <th class="text-center">No Criteria Data Found</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="align-middle" id="myTable">
                    @if ($alternatives->count())
                        @foreach ($alternatives as $alternative)
                            <tr>
                                <td scope="row" class="text-center">
                                    {{ ($alternatives->currentpage() - 1) * $alternatives->perpage() + $loop->index + 1 }}
                                </td>
                                <td>{{ Str::ucfirst(Str::upper($alternative->name)) }}</td>
                                <td class="text-center">{{ $alternative->kelas->kelas_name }}</td>
                                @foreach ($criterias as $key => $value)
                                    @if (isset($alternative->alternatives[$key]))
                                        <td class="text-center">{{ floatval($alternative->alternatives[$key]->alternative_value) }}</td>
                                    @else
                                        <td class="text-center">Empty</td>
                                    @endif
                                @endforeach
                                    <td class="text-center justify-content-center">
                                        <a href="{{ route('alternatif.edit', $alternative->id) }}"
                                            class="btn btn-warning btn-sm me-2" style="margin-bottom: 5px;">
                                            <i class="fas fa-pen-to-square"></i> Edit</a>
                                        <form action="{{ route('alternatif.destroy', $alternative->id) }}" method="POST"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm btnDelete" data-object="siswa">
                                                <i class="fas fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ 5 + $criterias->count() }}" class="text-center text-danger">Belum ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $alternatives->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Add Alternative Modal -->
<div class="modal fade" id="addAlternativeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addAlternativeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlternativeModalLabel">Tambah Alternatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('alternatif.store') }}" method="post">
                <div class="modal-body">
                    <span class="mb-2">Catatan :</span>
                    <ul class="list-group mb-2">
                        <li class="list-group-item bg-success text-white">Nilai minimum 0 dan maximum 100</li>
                        <li class="list-group-item bg-success text-white">Gunakan (.) jika memasukan nilai desimal</li>
                    </ul>
                    @csrf
                    <div class="my-2">
                        <label for="student_id" class="form-label">Daftar Siswa</label>
                        <select class="form-select @error('student_id') is-invalid @enderror" id="student_id"
                            name="student_id" required>
                            <option disabled selected value="">--Pilih Siswa--</option>
                            @if ($student_list->count())
                                @foreach ($student_list as $kelas => $students)
                                    <optgroup label="Kelas {{ $kelas }}: {{ $students->count() }}">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }} {{ $student->kelas->id }}">
                                                {{ $student->name }} - {{ $student->kelas->kelas_name }}
                                            </option>
                                        @endforeach
                                @endforeach
                                </optgroup>
                            @else
                                <option disabled selected>--NO DATA FOUND--</option>
                            @endif
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($criterias->count())
                        @foreach ($criterias as $key => $criteria)
                            <input type="hidden" name="criteria_id[]" value="{{ $criteria->id }}">
                            <div class="my-2">
                                <label for="{{ str_replace(' ', '', $criteria->name) }}" class="form-label">Nilai
                                    <b>{{ $criteria->name }}</b></label>
                                <input type="text" id="{{ str_replace(' ', '', $criteria->name) }}"
                                    class="form-control @error('alternative_value') is-invalid @enderror"
                                    name="alternative_value[]" placeholder="Masukkan Nilai"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46)"
                                    maxlength="5" autocomplete="off" required>
                                @error('alternative_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function submitForm() {
        var perPageSelect = document.getElementById('perPage');
        var perPageValue = perPageSelect.value;

        var currentPage = {{ $alternatives->currentPage() }};
        var url = new URL(window.location.href);
        var params = new URLSearchParams(url.search);

        params.set('perPage', perPageValue);

        if (!params.has('page')) {
            params.set('page', currentPage);
        }

        url.search = params.toString();
        window.location.href = url.toString();
    }
    // Event listener untuk menampilkan modal tambah alternatif saat tombol ditekan
    document.addEventListener('DOMContentLoaded', function () {
        var addButton = document.querySelector('[data-bs-target="#addAlternativeModal"]');
        addButton.addEventListener('click', function () {
            var modal = new bootstrap.Modal(document.getElementById('addAlternativeModal'));
            modal.show();
        });
    });
</script>
@endsection
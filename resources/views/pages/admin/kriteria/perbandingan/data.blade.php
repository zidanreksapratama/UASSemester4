@extends('layouts.admin')

@section('content')
{{-- {{ print_r($comparisons) }} --}}
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

    {{-- datatable --}}
    <div class="card mb-4">
        <div class="card-body table-responsive">
            <div class="d-sm-flex align-items-center justify-content-between">
                @if(auth()->user()->level == 'ADMIN')
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalChoose">
                        <i class="fas fa-plus me-1"></i>
                        Perbandingan Kriteria
                    </button>
                @endif
            </div>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Dibuat Oleh</th>
                        <th>Kriteria</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($comparisons->count())
                        @foreach ($comparisons as $comparison)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comparison->user->name }}</td>
                                <td>
                                    @foreach ($comparison->details->unique('criteria_id_second') as $key => $detail)
                                        {{ $detail->criteria_name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $comparison->created_at->toDayDateTimeString() }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('perbandingan.show', $comparison->id) }}"
                                            class="btn btn-success btn-sm me-2" style="margin-right: 5px;">
                                            <i class="fa-solid fa-trash-can"></i> Perbandingan
                                        </a>
                                        @if(auth()->user()->level == 'ADMIN')
                                            <form action="{{ route('perbandingan.destroy', $comparison->id) }}" method="POST"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm btnDelete" data-object="perbandingan kriteria">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-danger text-center p-4">
                                <h4>Belum ada data untuk perbandingan kriteria</h4>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Choose Criteria -->
    <div class="modal fade" id="modalChoose" tabindex="-1" aria-labelledby="modalChooseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalChooseLabel">Pilih Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('perbandingan.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" colspan="2">Nama Kriteria</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($criterias->count())
                                    @foreach ($criterias as $criteria)
                                        <tr>
                                            <th scope="row" class="text-center">
                                                <input type="checkbox" value="{{ $criteria->id }}" name="criteria_id[]">
                                            </th>
                                            <td>{{ $criteria->name }}</td>
                                            <td>{{ Str::ucfirst(Str::lower($criteria->kategori)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center text-danger" colspan="3">Tidak ditemukan kriteria</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalElement = document.getElementById('modalChoose');
        modalElement.addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('body').classList.remove('modal-open');
            document.querySelectorAll('.modal-backdrop').forEach(function(el) {
                el.remove();
            });
        });
    });
</script>
@endsection

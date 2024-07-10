@extends('layouts.admin')

@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-sm-6 col-md-8">
                <h1 class="mt-4">{{ $title }}</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Data Siswa</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        {{-- datatable --}}
        <div class="card col-lg-10">
            <div class="card-body table-responsive">
                <a href="{{ route('kelas.create') }}" type="button" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Kelas
                </a>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kelases->count())
                            @foreach ($kelases as $kelas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::ucfirst(Str::upper($kelas->kelas_name)) }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('kelas.students', $kelas->slug) }}"
                                                class="btn btn-primary btn-sm" style="margin-right: 5px;">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-warning btn-sm" style="margin-right: 5px;">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm btnDelClass" data-object="kelas">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-danger text-center p-4">
                                    <h4>Belum ada data Kelas</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

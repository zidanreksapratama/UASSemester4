@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Hasil Analisis Kriteria</h1>

    <!-- Tampilkan nilai matriks perbandingan untuk setiap kriteria -->
    @foreach ($matriksPerbandingan as $criteria => $matrix)
        <div class="card mb-4">
            <div class="card-header">
                <h3>Nilai Matriks Perbandingan untuk Kriteria {{ $criteria }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($matrix as $altName => $row)
                                    <th>{{ $altName }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matrix as $altName => $row)
                                <tr>
                                    <td>{{ $altName }}</td>
                                    @foreach ($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                @php
                                    $columnTotals = array_fill_keys(array_keys(reset($matrix)), 0);
                                @endphp
                                @foreach ($matrix as $altName => $row)
                                    @foreach ($row as $colKey => $value)
                                        @php
                                            $columnTotals[$colKey] += $value;
                                        @endphp
                                    @endforeach
                                @endforeach
                                @foreach ($columnTotals as $total)
                                    <td><strong>{{ $total }}</strong></td>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tampilkan normalisasi untuk setiap kriteria -->
        @if (isset($normalisasi[$criteria]))
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Normalisasi Kriteria {{ $criteria }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    @foreach ($normalisasi[$criteria] as $altName => $row)
                                        <th>{{ $altName }}</th>
                                    @endforeach
                                    <th>Rata-Rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normalisasi[$criteria] as $altName => $row)
                                    <tr>
                                        <td>{{ $altName }}</td>
                                        @php
                                            $total = array_sum($row);
                                            $average = count($row) > 0 ? $total / count($row) : 0;
                                        @endphp
                                        @foreach ($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                        <td><strong>{{ number_format($average, 9) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Tampilkan matriks perkalian setiap elemen dengan nilai prioritas -->
    @if (!empty($matriksPerkalian))
        <div class="card mb-4">
            <div class="card-header">
                <h3>Matriks Perkalian Setiap Elemen dengan Nilai Prioritas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->name }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matriksPerkalian as $altName => $values)
                                <tr>
                                    <td>{{ $altName }}</td>
                                    @foreach ($values as $value)
                                        <td>{{ number_format($value, 2) }}</td>
                                    @endforeach
                                    <td>{{ number_format(array_sum($values), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Tampilkan perangkingan alternatif -->
    @if (!empty($prioritasGlobal))
        <div class="card mb-4">
            <div class="card-header">
                <h3>Perangkingan Alternatif</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($criterias as $criteria)
                                    <th>Rata-Rata Normalisasi ({{ $criteria->name }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prioritasGlobal as $altName => $value)
                                <tr>
                                    <td>{{ $altName }}</td>
                                    @foreach ($criterias as $criteria)
                                        @php
                                            $avgNorm = isset($normalisasi[$criteria->name][$altName]) ? array_sum($normalisasi[$criteria->name][$altName]) / count($normalisasi[$criteria->name][$altName]) : 0;
                                        @endphp
                                        <td>{{ number_format($avgNorm, 9) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- perkalian elemen dengan bobot prioritas --}}
        <div class="mb-4">
            <h4 class="mb-0 text-gray-800">Matriks perkalian setiap elemen dengan nilai prioritas</h4>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Kriteria</th>
                    @foreach ($criteria_analysis->priorityValues as $priorityValue)
                        <th scope="col">{{ $priorityValue->criteria->name }}</th>
                    @endforeach
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @php($startAt = 0)
                @php($rowTotals = [])
                @foreach ($criteria_analysis->priorityValues as $priorityValue)
                    @php($rowTotal = 0)
                    <tr>
                        <th scope="row">
                            {{ $priorityValue->criteria->name }}
                        </th>
                        @foreach ($criteria_analysis->priorityValues as $key => $innerpriorityvalue)
                            <td class="text-center">
                                @php($res = floatval($criteria_analysis->details[$startAt]->comparison_result) * $innerpriorityvalue->value)
                                {{-- hasil perkalian --}}
                                {{ round(floatval($criteria_analysis->details[$startAt]->comparison_result), 2) }}
                                * {{ round($innerpriorityvalue->value, 2) }} =
                                {{ round($res, 3) }}
                                {{-- row total --}}
                                @php($rowTotal += Str::substr($res, 0, 11))
                            </td>
                            @php($startAt++)
                        @endforeach
                        @php(array_push($rowTotals, $rowTotal))
                        <td>
                            {{-- {{ $rowTotal }} --}}
                            {{ round($rowTotal, 3) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tampilkan hasil akhir -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Hasil Akhir</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>Hasil Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilAkhir as $altName => $value)
                                <tr>
                                    <td>{{ $altName }}</td>
                                    <td>{{ number_format($value, 9) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            Tidak ada data perangkingan alternatif yang tersedia.
        </div>
    @endif
</div>
@endsection


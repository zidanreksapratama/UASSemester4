<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\CriteriaAnalysis;
use App\Models\PriorityValue;

class RankingController extends Controller
{
    public function index(CriteriaAnalysis $criteriaAnalysis)
    {
        $title = "Hasil Analisis Kriteria";
        $criterias = Criteria::all();
        $alternatives = Alternative::with('student')->get();
        
        // Definisikan variabel $criteria_analysis
        $criteria_analysis = CriteriaAnalysis::with('priorityValues', 'details')->first();

        // Siapkan array untuk matriks perbandingan
        $matriksPerbandingan = [];

        foreach ($criterias as $criteria) {
            $row = [];

            foreach ($alternatives as $alternative1) {
                $rowInner = [];

                foreach ($alternatives as $alternative2) {
                    if ($alternative1->id === $alternative2->id) {
                        $rowInner[$alternative2->student->name] = 1; // Nilai perbandingan diri sendiri adalah 1
                    } else {
                        // Ambil nilai perbandingan dari kolom alternative_value dalam tabel alternatives
                        $nilai1 = Alternative::where('criteria_id', $criteria->id)
                            ->where('student_id', $alternative1->student_id)
                            ->value('alternative_value');

                        $nilai2 = Alternative::where('criteria_id', $criteria->id)
                            ->where('student_id', $alternative2->student_id)
                            ->value('alternative_value');

                        // Hitung nilai perbandingan (gunakan angka 1 jika nilai sama)
                        $nilai = $nilai1 / $nilai2;

                        $rowInner[$alternative2->student->name] = $nilai;
                    }
                }

                // Simpan baris perbandingan untuk kriteria saat ini
                $row[$alternative1->student->name] = $rowInner;
            }

            $matriksPerbandingan[$criteria->name] = $row;
        }

        // Hitung normalisasi
        $normalisasi = [];

        foreach ($matriksPerbandingan as $criteriaName => $rows) {
            $columnSums = array_fill_keys(array_keys($rows), 0);

            // Hitung jumlah setiap kolom
            foreach ($rows as $row) {
                foreach ($row as $key => $value) {
                    $columnSums[$key] += $value;
                }
            }

            // Normalisasi
            foreach ($rows as $rowKey => $row) {
                foreach ($row as $colKey => $value) {
                    $normalisasi[$criteriaName][$rowKey][$colKey] = $columnSums[$colKey] ? $value / $columnSums[$colKey] : 0;
                }
            }
        }

        $rowTotals = [];
        $startAt = 0;
        foreach ($criteria_analysis->priorityValues as $priorityValue) {
            $rowTotal = 0;

            foreach ($criteria_analysis->priorityValues as $key => $innerpriorityvalue) {
                $res = floatval($criteria_analysis->details[$startAt]->comparison_result) * $innerpriorityvalue->value;
                $rowTotal += $res;
                $startAt++;
            }

            $rowTotals[] = $rowTotal;
        }

        // Hitung prioritas global
        $prioritasGlobal = [];

        foreach ($criterias as $criteria) {
            foreach ($alternatives as $alternative) {
                $altName = $alternative->student->name;
                $prioritasGlobal[$criteria->name][$altName] = isset($normalisasi[$criteria->name][$altName]) ? array_sum($normalisasi[$criteria->name][$altName]) / count($normalisasi[$criteria->name][$altName]) : 0;
            }
        }

        // Hitung hasil akhir perhitungan berdasarkan nilai prioritas global dan rowTotals
        $hasilAkhir = [];

        foreach ($alternatives as $alternative) {
            $altName = $alternative->student->name;
            $total = 0;

            foreach ($criterias as $index => $criteria) {
                $criteriaName = $criteria->name;
                $prioritas = $prioritasGlobal[$criteriaName][$altName] ?? 0;
                $total += $prioritas * $rowTotals[$index];
            }

            $hasilAkhir[$altName] = $total;
        }

        return view('pages.admin.rank.index', compact('title', 'criterias', 'matriksPerbandingan', 'normalisasi', 'prioritasGlobal', 'alternatives', 'hasilAkhir', 'criteria_analysis'));
    }
}

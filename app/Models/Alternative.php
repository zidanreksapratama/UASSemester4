<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['criteria_id', 'student_id', 'kelas_id', 'alternative_value'];


    // Relasi dengan user, criteria, studentList, dan kelas
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public function studentList()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Mendapatkan pembagi berdasarkan kriteria
    public static function getDividerByCriteria($criterias)
    {
        $dividers = [];

        foreach ($criterias as $criteria) {
            \Log::info("Criteria Data: " . json_encode($criteria));
            $divider = null;

            if ($criteria->kategori === 'BENEFIT') {
                $divider = static::where('criteria_id', $criteria->id)
                    ->max('alternative_value');
            } else if ($criteria->kategori === 'COST') {
                $divider = static::where('criteria_id', $criteria->id)
                    ->min('alternative_value');
            }

            \Log::info("Criteria ID: {$criteria->id}, Kategori: {$criteria->kategori}, Divider Value: {$divider}");

            $data = [
                'criteria_id'   => $criteria->id,
                'criteria_name' => $criteria->name,
                'kategori'      => $criteria->kategori,
                'divider_value' => floatval($divider)
            ];

            $dividers[] = $data;
        }

        return $dividers;
    }

    // Mendapatkan alternatif berdasarkan kriteria
    public static function getAlternativesByCriteria($criteriaIds)
    {
        $results = static::with('criteria', 'studentList', 'kelas')
            ->whereIn('criteria_id', $criteriaIds)
            ->get();

        $finalRes = [];

        foreach ($results as $result) {
            $key = $result->student_id;

            if (!isset($finalRes[$key])) {
                $finalRes[$key] = [
                    'student_id' => $key,
                    'student_name' => $result->studentList->name,
                    'kelas_id' => $result->kelas->id,
                    'kelas_name' => $result->kelas->kelas_name,
                    'criteria' => [], // Inisialisasi array untuk kriteria
                    'alternative_val' => []
                ];
            }

            if ($result->criteria) {
                $finalRes[$key]['criteria'][] = [
                    'id' => $result->criteria->id,
                    'criteria_name' => $result->criteria->name, // Pastikan nama kriteria diambil
                    'value' => $result->alternative_value,
                ];
            }
            $finalRes[$key]['alternative_val'][] = $result->alternative_value;
        }
        return array_values($finalRes);
    }

    // Memeriksa keberadaan alternatif berdasarkan kriteria
    public static function checkAlternativeByCriterias($criterias)
    {
        foreach ($criterias as $criteria) {
            if (!static::where('criteria_id', $criteria)->exists()) {
                return false;
            }
        }

        return true;
    }
}

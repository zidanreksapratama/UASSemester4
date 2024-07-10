<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComparisonDetail extends Model
{
    protected $table = 'comparison_details';
    protected $fillable = [
        'criteria_id',
        'alternative_id',
        'comparison_result',
    ];

    // Relasi ke Criteria
    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    // Relasi ke Alternative
    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }
}

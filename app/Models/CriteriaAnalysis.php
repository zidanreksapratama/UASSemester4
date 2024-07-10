<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaAnalysis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        // one-to-many
        return $this->hasMany(CriteriaAnalysisDetail::class);
    }

    public function priorityValues()
    {
        return $this->hasMany(PriorityValue::class);
    }
}

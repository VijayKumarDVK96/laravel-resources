<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'contact_number', 'gender', 'specialization', 'work_ex_year', 'candidate_dob', 'address', 'resume'];

    // Accessor
    public function getCandidateDobAttribute($value) {
        return date('Y-m-d', $value);
    }

    // Mutator
    public function setCandidateDobAttribute($value) {
        $this->attributes['candidate_dob'] = strtotime($value);
    }
}

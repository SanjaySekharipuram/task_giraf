<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'email',
        'phone',
        'location',
        'job_title',
        'job_description',
        'job_type'
    ];
    
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}

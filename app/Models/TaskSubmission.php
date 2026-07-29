<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model{

    protected $fillable = [
        'task_id',
        'submitted_by',
        'proof_image',
        'proof_link',
        'notes',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function submitter(){
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
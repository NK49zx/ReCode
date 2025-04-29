<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for user reports (reporting users, questions, or answers)
class Report extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'question_id',
        'answer_id',
        'type',
        'reason',
        'status',
        'admin_notes',
    ];

    // User who submitted the report
    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    // User being reported
    public function reportedUser() {
        return $this->belongsTo(User::class, 'reported_user_id');
    }
    // Question being reported
    public function question() {
        return $this->belongsTo(Question::class);
    }
    // Answer being reported
    public function answer() {
        return $this->belongsTo(Answer::class);
    }
}

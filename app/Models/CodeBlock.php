<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeBlock extends Model
{
    protected $fillable = ['answer_id', 'tag_id', 'code'];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}

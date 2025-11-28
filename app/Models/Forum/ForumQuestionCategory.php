<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumQuestionCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(\App\Models\Forum\ForumQuestion::class);
    }
}

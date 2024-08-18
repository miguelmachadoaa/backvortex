<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Answer;
use App\Models\User;

class Question extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'question';

    protected $guarded = ['id'];

    public function answers() {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

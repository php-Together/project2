<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Task;
use App\Models\User;

class Comment extends Model // 댓글
{
    use HasFactory,SoftDeletes;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 모델 연관 관리
    public function tasks(){     
        return $this->belongsTo(Task::class,'task_id','id');
    }
    public function  users(){      
        return $this->belongsTo(User::class,'user_id','id');
    }
}

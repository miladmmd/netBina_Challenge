<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable=['title','created_by','confirmed_by','last_assigned_user_id','deadline','status'];

    public function users()
    {
        return $this->belongsToMany(User::class,'task_user','task_id','user_id')
            ->withPivot(['allocator_id','allocator_email'])
            ->using(TaskUser::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class,'confirmed_by');
    }

    public function last_assigned()
    {
        return $this->belongsTo(User::class,'last_assigned_user_id');
    }

    public function scopePendingTask($query)
    {
        return $query->where('status','pending');
    }

}

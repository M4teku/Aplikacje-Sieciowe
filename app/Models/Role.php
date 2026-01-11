<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'id_role';
    public $timestamps = true;
    
    protected $fillable = ['name', 'is_active'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'id_role', 'id_user');
    }
}
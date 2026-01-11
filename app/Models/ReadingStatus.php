<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingStatus extends Model
{
    use HasFactory;

    protected $table = 'reading_status';
    protected $primaryKey = 'id_status';
    public $timestamps = false; 
    
    protected $fillable = ['name'];
    
    public function userBooks()
    {
        return $this->hasMany(UserBook::class, 'id_status');
    }
}
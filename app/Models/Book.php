<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'book';
    protected $primaryKey = 'id_book';
    public $timestamps = true;
    
    protected $fillable = [
        'title', 'author', 'genre', 'description', 
        'created_by', 'updated_by'
    ];
    
    // Twórca książki
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
    
    // Osoba która ostatnio edytowała
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }
    
    // Użytkownicy którzy śledzą tę książkę
    public function trackedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_book', 'id_book', 'id_user')
                    ->withPivot('id_status', 'progress', 'start_date', 'planned_end_date');
    }
    
    // Recenzje książki
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_book');
    }
    
    // Średnia ocena
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
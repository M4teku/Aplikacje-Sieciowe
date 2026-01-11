<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';
    protected $primaryKey = 'id_review';
    public $timestamps = true;
    
    protected $fillable = ['id_user', 'id_book', 'rating', 'content'];
    
    // Walidacja ratingu
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($review) {
            if ($review->rating < 1 || $review->rating > 5) {
                throw new \Exception('Ocena musi być między 1 a 5');
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }
}
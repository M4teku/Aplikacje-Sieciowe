<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $table = 'user_book';
    
    
    protected $primaryKey = null; // Laravel nie wspiera dobrze kluczy złożonych
    public $incrementing = false;
    
    public $timestamps = true;
    
    protected $fillable = [
        'id_user', 'id_book', 'id_status', 
        'progress', 'start_date', 'planned_end_date'
    ];
    
    // Cast typów
    protected $casts = [
        'start_date' => 'date',
        'planned_end_date' => 'date',
    ];
    
    // Walidacja
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($userBook) {
            // Walidacja progresu
            if ($userBook->progress < 0 || $userBook->progress > 100) {
                throw new \Exception('Postęp musi być między 0 a 100%');
            }
            
            // Walidacja dat
            if ($userBook->start_date && $userBook->planned_end_date) {
                if ($userBook->planned_end_date < $userBook->start_date) {
                    throw new \Exception('Data zakończenia nie może być przed rozpoczęciem');
                }
                
                if ($userBook->planned_end_date < now()) {
                    throw new \Exception('Data zakończenia nie może być w przeszłości');
                }
            }
        });
    }
    
    // Relacje
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }
    
    public function status()
    {
        return $this->belongsTo(ReadingStatus::class, 'id_status');
    }
    
    // Metoda do ustawiania klucza złożonego
    public function setKeysForSaveQuery($query)
    {
        $query->where('id_user', '=', $this->getAttribute('id_user'))
              ->where('id_book', '=', $this->getAttribute('id_book'));
        return $query;
    }
}
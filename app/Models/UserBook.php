<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $table = 'user_book';
    
    // Wyłączenie auto-increment i klucza głównego dla tabeli z kluczem złożonym
    protected $primaryKey = null;
    public $incrementing = false;
    
    public $timestamps = true;
    
    protected $fillable = [
        'id_user', 'id_book', 'id_status', 
        'progress', 'start_date', 'planned_end_date'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'planned_end_date' => 'date',
    ];
    
    // Nadpisać metodę delete() dla tabel bez klucza głównego
    public function delete()
    {
        return \DB::table($this->table)
            ->where('id_user', $this->id_user)
            ->where('id_book', $this->id_book)
            ->delete();
    }
    
    // Nadpisać metodę save() dla tabel bez klucza głównego
    public function save(array $options = [])
    {
        if ($this->exists) {
            // Update
            return \DB::table($this->table)
                ->where('id_user', $this->id_user)
                ->where('id_book', $this->id_book)
                ->update($this->attributes);
        } else {
            // Insert
            return \DB::table($this->table)->insert($this->attributes);
        }
    }
    
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
}
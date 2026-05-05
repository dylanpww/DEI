<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // Beri tahu Laravel bahwa primary key-nya bukan 'id'
    protected $primaryKey = 'Address_ID';

    protected $fillable = [
        'user_ID', 
        'name', 
        'completeAddress', 
        'telephoneNumber', 
        'notes'
    ];

    public function user()
    {
        // Beri tahu relasi bahwa foreign key-nya adalah 'user_ID'
        return $this->belongsTo(User::class, 'user_ID');
    }
}

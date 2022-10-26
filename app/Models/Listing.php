<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // Add [title] to fillable property to allow mass assignment on [App\Models\Listing].
    //bez ovog ne pusti te da ubacis u DB citav red valuesa
    protected $fillable = [
        'title',
        'user_id',
        'company',
        'logo',
        'location',
        'website',
        'email',
        'description',
        'tags'
    ];
    //bez ovog gore nemos submitat formu
    //u array stavimo sve sto hocemo da allowamo mass assignment
    //kao default protection da bypassamo

    //TERNARY vs NULL COALESCING, below identical
    // isset($_GET['username']) ? $_GET['username'] : 'not passed';
    // $username = $_GET['username'] ?? 'not passed';

    public function scopeFilter($query, array $filters) {
        // dd($filters['tag']); //provjerio ferceral
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');  //where, kao sql(tags col, like operator, % koliko god karaktera)
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')       //ovde ako ima search trazice title, ali hocemo i tekst i tagove da pretrazi pa onda dodajemo jos linija
            ->orWhere('description', 'like', '%' . request('search') . '%')     //i description ako ima tu rijec
            ->orWhere('tags', 'like', '%' . request('search') . '%');           //i tagovi, ali sada pulla iz search keyworda u urlu
        }
    }

    //relationship to user
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
        //u ovom Listing modelu smo definisali da
        //ovaj model BELONGS TO user modelu po koloni user id
        //u user modelu moramo dodatno namjestiti
    }

}

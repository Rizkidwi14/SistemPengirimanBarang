<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    // Di route tidak manggil data berdasarkan id di url
    public function getRouteKeyName()
    {
        return 'kode';
    }
}

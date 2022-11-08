<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Toko extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'toko';
    protected $guarded = ["id"];
    protected $dates = ['deleted_at'];

    public function pengiriman()
    {
        $this->hasMany(Pengiriman::class);
    }

    // Di route tidak manggil data berdasarkan id di url
    public function getRouteKeyName()
    {
        return 'kode_toko';
    }
}

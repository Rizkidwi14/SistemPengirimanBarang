<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $guarded = ["id"];
    protected $casts = [
        'barang' => 'array',
    ];

    // Di route tidak manggil data berdasarkan id di url
    public function getRouteKeyName()
    {
        return 'no_stpb';
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class)->withTrashed();
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class)->withTrashed();
    }
}

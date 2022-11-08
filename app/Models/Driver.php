<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;



class Driver extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $guarded = ["id"];
    protected $dates = ['deleted_at'];

    public function pengiriman()
    {
        $this->hasMany(Pengiriman::class);
    }

    // Di route tidak manggil data berdasarkan id di url
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}

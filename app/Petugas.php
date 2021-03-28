<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_petugas', 'tanggal_lahir','jenis_kelamin','no_telp','email',
    ];
}

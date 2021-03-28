<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masyarakats extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik', 'nama_lengkap','tanggal_lahir','jenis_kelamin','no_telp','email',
    ];
}

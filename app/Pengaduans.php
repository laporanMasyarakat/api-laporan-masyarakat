<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaduans extends Model
{
    protected $primaryKey = 'id_pengaduan';
    protected $fillable = [
        'judul_laporan', 'tgl_pengaduan','username','isi_laporan','kota','longtitude','latitude','foto','status',
    ];
}

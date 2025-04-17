<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkmModel extends Model
{
    use HasFactory;

    // Karena tabel kita bernama "ukm" (bukan plural), kita harus override:
    protected $table = 'ukm';

    // Field yang boleh di‐mass assign
    protected $fillable = [
        'name',
        'description',
        'contact_person',
        'email',
        'phone',
        'website',
        'logo_path',
        'status',
        'created_by',
    ];

    /**
     * Relasi: UKM dimiliki oleh satu Admin
     */
    public function admins()
    {
        return $this->belongsTo(AdminsModel::class, 'created_by');
    }
}

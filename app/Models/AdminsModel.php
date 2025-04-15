<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminsModel extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password_hash',
        'name',
        'email',
    ];

    // Sembunyikan password hash saat di‐serialize
    protected $hidden = [
        'password_hash',
    ];

    /**
     * Relasi: Admin punya banyak UKM
     */
    public function ukms()
    {
        return $this->hasMany(UkmModel::class, 'created_by');
    }
}

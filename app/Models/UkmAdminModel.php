<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkmAdminModel extends Model
{
    use HasFactory;

    protected $table = 'ukm_admin';

    protected $primaryKey = 'nim';

    protected $fillable = [
        'nim',
        'name',
        'password_hash',
        'phone',
        'email',
        'ukm_id',
        'photo'
    ];

    public function ukm()
    {
        return $this->belongsTo(UkmModel::class);
    }
}

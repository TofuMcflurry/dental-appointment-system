<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $primaryKey = 'setting_id';
    protected $table = 'user_settings';
    
    protected $fillable = [
        'user_id',
        'otp_code',
        'otp_expires_at',
        'language',
        'dark_mode'
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'otp_expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
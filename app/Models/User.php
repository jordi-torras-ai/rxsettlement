<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'employer_id',
        'user_type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class);
    }

    public function vendorCoverages()
    {
        return $this->hasMany(VendorCoverage::class);
    }

    public function planDesignYears()
    {
        return $this->hasMany(PlanDesignYear::class);
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }
}

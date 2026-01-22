<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    protected $fillable = [
        'name',
        'legal_name',
        'dba',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'authorized_contact_name',
        'authorized_contact_email',
        'authorized_contact_phone',
        'billing_contact_name',
        'billing_contact_email',
        'billing_contact_phone',
        'headquartered_state',
        'operating_states',
        'fein',
        'naics_sector',
        'other_comments',
    ];

    protected $casts = [
        'operating_states' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

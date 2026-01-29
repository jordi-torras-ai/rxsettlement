<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{
    protected $fillable = [
        'order',
        'type',
        'rates',
        'definition',
        'other_industry_terms_used',
    ];
}

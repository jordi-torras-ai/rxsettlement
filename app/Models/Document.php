<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'document_type_id',
        'year',
        'intake_id',
        'budget_premium_equivalent_funding_monthly_rate_id',
        'file_path',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $document): void {
            if (blank($document->file_path)) {
                return;
            }

            Storage::disk('r2')->delete($document->file_path);
        });
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }

    public function budgetPremiumEquivalentFundingMonthlyRate(): BelongsTo
    {
        return $this->belongsTo(BudgetPremiumEquivalentFundingMonthlyRate::class);
    }
}

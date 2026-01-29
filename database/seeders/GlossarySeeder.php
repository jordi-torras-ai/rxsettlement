<?php

namespace Database\Seeders;

use App\Models\Glossary;
use Illuminate\Database\Seeder;

class GlossarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $rows = [
            [
                'order' => 10,
                'type' => 'General',
                'rates' => 'Fee - Administrative Services Only (ASO)',
                'definition' => 'A per employee per month (PEPM) fee charged by a payor (insurer) or other third-party administrator (TPA) responsible for administering a group employee benefit plan to cover expenses related to recordkeeping and/or other administrative costs. Include PEPM charges for network access and any other additional programs related to the medical plan that are not included or illustrated below.',
                'other_industry_terms_used' => 'Administrative Services Fee, Admin Fee',
            ],
            [
                'order' => 20,
                'type' => 'General',
                'rates' => 'Fee - HSA/HRA Account',
                'definition' => 'PEPM fee for administration of an HSA or HRA',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 30,
                'type' => 'General',
                'rates' => 'Fee - Disease Management',
                'definition' => 'PEPM fee for use of disease management programs',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 40,
                'type' => 'General',
                'rates' => 'Fee - Tele-health',
                'definition' => 'PEPM fee for use of tele-health programs',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 50,
                'type' => 'General',
                'rates' => 'Fee - Wellness',
                'definition' => 'PEPM fee for use of wellness programs that have an admin fee component or Wellness allowance/credit from carrier',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 60,
                'type' => 'General',
                'rates' => 'Fee - Rx Rebate Credit',
                'definition' => 'PEPM admin credit given for pharmacy rebates - should be a negative value',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 70,
                'type' => 'General',
                'rates' => 'Fee - Pharmacy Carveout - (PBM, PBA, GPO)',
                'definition' => 'PEPM fee for pharmacy administration that is carved out or with Prescription Benefit Manager (PBM), Prescription Benefit Administrator (PBA), Group Purchasing Organization (GPO)',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 90,
                'type' => 'Reinsurance',
                'rates' => 'Fee - Spec Stop Loss',
                'definition' => 'PEPM fee for specific stop loss coverage, may be broken out by coverage tier or composite, but cannot be accepted broken out by enrollment option (base vs high plan, etc.)',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 100,
                'type' => 'Reinsurance',
                'rates' => 'Fee - Stop Loss Agg',
                'definition' => 'PEPM fee for aggregate stop loss coverage, may be broken out by coverage tier or composite, but cannot be accepted broken out by enrollment option (base vs high plan, etc.)',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 110,
                'type' => 'Reinsurance',
                'rates' => 'Contract Basis',
                'definition' => 'The effective policy period for a Stop Loss contract. Typically structured as Incurred/Paid. Examples: PAID, 36/12, 24/12, 12/18, 12/15, 12/12',
                'other_industry_terms_used' => 'May also list out the actual incurred date range and paid date range',
            ],
            [
                'order' => 120,
                'type' => 'General',
                'rates' => 'Budget Premium-Equivalent Funding Monthly Rates*',
                'definition' => 'Total monthly rates for each plan by coverage tier, including employer and employee contributions',
                'other_industry_terms_used' => 'Budget rates, Premium equivalent rates, COBRA equivalent rates (excluding 2% admin)',
            ],
            [
                'order' => 130,
                'type' => 'General',
                'rates' => 'Admin Fee Group',
                'definition' => 'This is a key to identify the admin fees that go with each plan, if separate admin fees apply',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 140,
                'type' => 'General',
                'rates' => 'Employee Monthly Contributions*',
                'definition' => 'Monthly employee contribution for each plan by coverage tier',
                'other_industry_terms_used' => 'Employee premiums; monthly paycheck deductions',
            ],
            [
                'order' => 150,
                'type' => 'General',
                'rates' => 'Fee - Misc',
                'definition' => 'PEPM Broker or Consultant Compensation ($ Amount or % Amount) of payment, whether commission or fee based which are included in the Premium Equivalents/Funding rates only. (Commission and/or consulting fees billed separately to the client is not included here)',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 160,
                'type' => 'General',
                'rates' => 'Per Subscriber (per employee)',
                'definition' => "A Stop Loss Policy that covers only the subscribing members under the subscriber of the employer's healthcare plan. Most stop loss policies do not use this option.",
                'other_industry_terms_used' => 'Per Contract, Per Family Unit',
            ],
            [
                'order' => 170,
                'type' => 'General',
                'rates' => 'Per Member',
                'definition' => "A Stop Loss Policy that covers all members insured under the employer's healthcare plan. Most stop loss policies use this option.",
                'other_industry_terms_used' => 'Per Covered Individual',
            ],
            [
                'order' => 180,
                'type' => 'General',
                'rates' => 'Aggregating Specific Deductible',
                'definition' => 'Reimbursement point at which the Stop Loss Policy will cover all claims for an employer. (Group Level)',
                'other_industry_terms_used' => 'Individual Aggregating Deductible (IAD)',
            ],
            [
                'order' => 190,
                'type' => 'General',
                'rates' => 'Specific Deductible',
                'definition' => 'Reimbursement point at which the Stop Loss Policy will cover claims for any member exceeding this total. (Patient Level)',
                'other_industry_terms_used' => 'ISL',
            ],
            [
                'order' => 200,
                'type' => 'General',
                'rates' => 'Aggregating Factors',
                'definition' => 'The amount, expressed in dollars per employee and/or dependents per month used to define the claim liability for each month',
                'other_industry_terms_used' => 'ASL',
            ],
            [
                'order' => 210,
                'type' => 'General',
                'rates' => 'Aggregating Factors - Composite',
                'definition' => 'When Aggregate Factors are broken out for different plans in the Stop Loss Contract, a composite must be provided to input totals in Innovu Lens',
                'other_industry_terms_used' => null,
            ],
            [
                'order' => 220,
                'type' => 'General',
                'rates' => 'Corridor',
                'definition' => 'Risk level above expected claims. Typically ranges from 110 to 175%',
                'other_industry_terms_used' => null,
            ],
        ];

        $payload = array_map(function (array $row) use ($now): array {
            return array_merge($row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $rows);

        Glossary::query()->upsert($payload, ['order']);
    }
}

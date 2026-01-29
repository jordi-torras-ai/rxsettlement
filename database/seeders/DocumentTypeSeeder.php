<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $rows = [
            ['description' => 'CENSUS'],
            ['description' => 'Summary Benefit Coverage (SBC)'],
            ['description' => 'Master Plan Document (MPD) - unless Summary Plan Description (SPD) is used as Master Document'],
            ['description' => 'Summary Plan Description (SPD)'],
            ['description' => 'Medical/Rx Bundled'],
            ['description' => 'Medical (separate admin for Rx)'],
            ['description' => 'RX(separate admin for Medical)'],
        ];

        $payload = array_map(function (array $row) use ($now): array {
            return array_merge($row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $rows);

        DocumentType::query()->upsert($payload, ['description']);
    }
}

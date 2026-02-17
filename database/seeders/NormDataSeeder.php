<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NormTable;
use App\Models\NormRange;
use App\Models\Exam;

class NormDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get the OLSAT Exam
        $exam = Exam::where('title', 'OLSAT Entrance Exam')->first();
        if (!$exam) {
            $this->command->error("OLSAT Exam not found. Please run IntelligenceExamSeeder first.");
            return;
        }

        $normTable = NormTable::updateOrCreate(
            ['exam_id' => $exam->id, 'name' => 'OLSAT Simulated Norms'],
            ['description' => 'Standardized norms for 50-item OLSAT (Verbal + Non-Verbal).']
        );

        $this->command->info("Seeding Norm Table: {$normTable->name}");

        // Clear existing ranges to avoid duplicates during re-seed
        $normTable->normRanges()->delete();

        $entriesCount = 0;

        // 2. Define Age Brackets (Years and Month Ranges)
        $ages = range(5, 24);
        $monthBrackets = [
            ['start' => 0, 'end' => 2],
            ['start' => 3, 'end' => 5],
            ['start' => 6, 'end' => 8],
            ['start' => 9, 'end' => 11],
        ];

        // 3. Generate Data
        foreach ($ages as $age) {
            foreach ($monthBrackets as $months) {
                // Generate Raw Scores 0 to 50
                for ($raw = 0; $raw <= 50; $raw++) {
                    
                    // --- Simulation Logic ---
                    // Higher age = slightly lower SAI for same raw score (harder to impress)
                    // Higher raw score = higher SAI
                    
                    $ageFactor = ($age - 14) * 2; 
                    
                    // Base SAI curve (approximate)
                    // Raw 0 -> SAI ~60
                    // Raw 30 -> SAI ~100
                    // Raw 60 -> SAI ~140
                    $sai = 60 + floor(($raw / 60) * 80) - $ageFactor;
                    
                    // Ensure SAI is within reasonable bounds
                    $sai = max(50, min(150, $sai));

                    // Percentile from SAI (Normal Distribution approximation)
                    // SAI 100 = 50th percentile
                    // SAI 116 = 84th percentile (sigma=16)
                    $z = ($sai - 100) / 16;
                    $percentile = $this->calculatePercentile($z);
                    
                    // Stanine from Percentile
                    $stanine = $this->getStanine($percentile);
                    
                    // Description from Stanine
                    $description = $this->getDescription($stanine);

                    NormRange::create([
                        'norm_table_id' => $normTable->id,
                        'age_years' => $age,
                        'age_months_start' => $months['start'],
                        'age_months_end' => $months['end'],
                        'raw_score' => $raw,
                        'sai' => (int) $sai,
                        'percentile' => (int) $percentile,
                        'stanine' => $stanine,
                        'description' => $description,
                    ]);

                    $entriesCount++;
                }
            }
        }

        $this->command->info("Successfully generated {$entriesCount} norm entries.");
    }

    private function calculatePercentile($z)
    {
        // Simple approximation of CDF for standard normal distribution
        // Using error function approximation or pre-calculated map would be better, 
        // but this is enough for mock data.
        $b1 =  0.319381530;
        $b2 = -0.356563782;
        $b3 =  1.781477937;
        $b4 = -1.821255978;
        $b5 =  1.330274429;
        $p  =  0.2316419;
        $c2 =  0.39894228;

        $a = abs($z);
        if ($a > 6.0) { return 1.0; } 
        
        $t = 1.0 / (1.0 + $a * $p);
        $b = $c2 * exp((-$z) * ($z) / 2.0);
        $n = (($b5 * $t + $b4) * $t + $b3) * $t;
        $n = (($n + $b2) * $t + $b1) * $t;
        $n = 1.0 - $b * $n;
        $result = ($z < 0.0) ? 1.0 - $n : $n;

        return min(99, max(1, round($result * 100)));
    }

    private function getStanine($percentile)
    {
        if ($percentile <= 4) return 1;
        if ($percentile <= 11) return 2;
        if ($percentile <= 23) return 3;
        if ($percentile <= 40) return 4;
        if ($percentile <= 60) return 5;
        if ($percentile <= 77) return 6;
        if ($percentile <= 89) return 7;
        if ($percentile <= 96) return 8;
        return 9;
    }

    private function getDescription($stanine)
    {
        if ($stanine <= 3) return "Low / Below Average";
        if ($stanine <= 6) return "Average";
        return "High / Above Average";
    }
}

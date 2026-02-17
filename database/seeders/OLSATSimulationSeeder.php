<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\User;
use App\Models\ExamAttempt;
use App\Models\Answer;
use App\Models\ExamResult;
use App\Models\NormTable;
use App\Models\ResultSignature;

class OLSATSimulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get Models
        $exam = Exam::where('title', 'OLSAT Entrance Exam')->first();
        if (!$exam) {
            $this->command->error("OLSAT Exam not found. Run IntelligenceExamSeeder first.");
            return;
        }

        $studentModel = \App\Models\Student::first();
        if (!$studentModel) {
            $this->command->error("No student found. Please seed students first.");
            return;
        }
        $user = $studentModel->user;

        $psychometrician = User::whereHas('role', fn($q) => $q->where('slug', 'psychometrician'))->first();
        $counselor = User::whereHas('role', fn($q) => $q->where('slug', 'guidance-counselor'))->first();

        $this->command->info("Simulating OLSAT for Student: {$studentModel->first_name} {$studentModel->last_name}");

        // 2. Create Attempt
        $attempt = ExamAttempt::create([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'status' => 'completed',
            'started_at' => now()->subMinutes(50),
            'submitted_at' => now()->subMinutes(5),
        ]);

        // 3. Create Answers (Simulate 45/50 score)
        $questions = $exam->questions;
        $correctCount = 0;
        
        foreach ($questions as $index => $question) {
            // Make first 45 correct, last 5 wrong
            $isCorrect = $index < 45;
            $answerText = $isCorrect ? $question->correct_answer : 'Wrong Answer';
            
            Answer::create([
                'exam_attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer_text' => $answerText,
                'is_correct' => $isCorrect,
                'points_earned' => $isCorrect ? 1 : 0,
            ]);

            if ($isCorrect) $correctCount++;
        }

        $attempt->update(['raw_score' => $correctCount]);
        $this->command->info("Simulated Score: {$correctCount}/50");

        // 4. Create Result with Norm Lookup
        $ageYears = 15; // Simulated age
        $ageMonths = 0;

        $normTable = NormTable::where('exam_id', $exam->id)->first();
        $normData = null;
        if ($normTable) {
            $normData = $normTable->findNormRange($ageYears, $ageMonths, $correctCount);
        }

        $result = ExamResult::create([
            'exam_attempt_id' => $attempt->id,
            'student_id' => $studentModel->id,
            'exam_id' => $exam->id,
            'raw_score' => $correctCount,
            'total_score' => $correctCount,
            'sai' => $normData ? $normData->sai : 115,
            'percentile' => $normData ? $normData->percentile : 85,
            'stanine' => $normData ? $normData->stanine : 7,
            'performance_description' => $normData ? $normData->description : 'Above Average',
            'age_at_exam' => $ageYears,
            'grade_level_at_exam' => $studentModel->current_grade_level,
            'psychometrician_notes' => 'The student shows strong verbal and non-verbal reasoning skills. Scores are consistent across both sections of the OLSAT.',
            'status' => 'official',
        ]);

        // 5. Add Signatures
        if ($psychometrician) {
            ResultSignature::create([
                'exam_result_id' => $result->id,
                'user_id' => $psychometrician->id,
                'role' => 'psychometrician',
                'signed_at' => now()->subMinutes(2),
                'comments' => 'Reviewed and verified.',
            ]);
        }

        if ($counselor) {
            ResultSignature::create([
                'exam_result_id' => $result->id,
                'user_id' => $counselor->id,
                'role' => 'guidance_counselor',
                'signed_at' => now()->subMinute(),
                'comments' => 'Final approval granted.',
            ]);
        }

        $this->command->info("Simulation Complete. Result ID: {$result->id}");
    }
}

<?php

namespace App\Services;

use App\Models\ExamAttempt;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\NormTable;
use App\Models\ResultSignature;

class ResultService
{
    /**
     * Generate exam result from an exam attempt
     */
    public function generateResult(ExamAttempt $attempt)
    {
        // Get student
        $student = Student::where('user_id', $attempt->user_id)->firstOrFail();
        
        // Calculate age at exam time
        $ageAtExam = $student->getAgeInYears($attempt->submitted_at);
        $ageDecomposed = $student->getAgeDecomposed($attempt->submitted_at);
        
        // Calculate raw score
        $rawScore = $attempt->calculateRawScore();
        
        // Find norm table for this exam
        $normTable = NormTable::where('exam_id', $attempt->exam_id)->first();
        
        $performanceDescription = null;
        $percentile = null;
        $sai = null;
        $stanine = null;
        
        if ($normTable) {
            // Lookup interpretation
            $normRange = $normTable->findNormRange($ageDecomposed['years'], $ageDecomposed['months'], $rawScore);
            
            if ($normRange) {
                $performanceDescription = $normRange->description;
                $percentile = $normRange->percentile;
                $sai = $normRange->sai;
                $stanine = $normRange->stanine;
            }
        }
        
        // Create or update result
        $result = ExamResult::updateOrCreate(
            ['exam_attempt_id' => $attempt->id],
            [
                'student_id' => $student->id,
                'exam_id' => $attempt->exam_id,
                'raw_score' => $rawScore,
                'total_score' => $attempt->exam->total_points ?? 0,
                'sai' => $sai,
                'stanine' => $stanine,
                'age_at_exam' => $ageAtExam,
                'grade_level_at_exam' => $attempt->grade_level_at_attempt ?? $student->current_grade_level,
                'performance_description' => $performanceDescription,
                'percentile' => $percentile,
                'status' => 'draft',
            ]
        );
        
        return $result;
    }
    
    /**
     * Sign result as psychometrician or counselor
     */
    public function signResult(ExamResult $result, $user, $role, $comments = null)
    {
        ResultSignature::create([
            'exam_result_id' => $result->id,
            'user_id' => $user->id,
            'role' => $role,
            'signed_at' => now(),
            'comments' => $comments,
            'ip_address' => request()->ip(),
        ]);
        
        // Update workflow status
        if ($role === 'counselor') {
            $result->status = 'counselor_approved';
            $result->save();
        } 
        // Psychometrician signature is handled in controller for 'for_counselor' status
        
        return $result;
    }
}

<?php

namespace Database\Seeders;

use App\Models\Exam;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntelligenceExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create OLSAT Entrance Exam
        $exam = Exam::create([
            'title' => 'OLSAT Entrance Exam',
            'description' => 'Otis-Lennon School Ability Test: Measures abstract thinking and reasoning ability.',
            'target_grade_level' => 'Grade 7-12',
            'time_limit' => 45, // Total time (approx)
            'active' => true,
        ]);

        $this->command->info("Created Exam: {$exam->title}");

        // 2. Create Section 1: Verbal Reasoning (30 items)
        $verbalSection = $exam->sections()->create([
            'title' => 'Verbal Reasoning',
            'description' => 'Measures ability to understand and reason using words.',
            'order' => 1,
        ]);

        $this->createQuestions($verbalSection, 30, 'Verbal');

        // 3. Create Section 2: Non-Verbal Reasoning (20 items)
        $nonVerbalSection = $exam->sections()->create([
            'title' => 'Non-Verbal Reasoning',
            'description' => 'Measures ability to reason using geometric shapes and figures.',
            'order' => 2,
        ]);

        $this->createQuestions($nonVerbalSection, 20, 'Non-Verbal');
    }

    private function createQuestions($section, $count, $type)
    {
        $faker = Factory::create();

        $verbalQuestions = [
            ['q' => 'Find the word that is most nearly OPPOSITE in meaning to: RELUCTANT', 'options' => ['Eager', 'Hesitant', 'Unwilling', 'Slow', 'Afraid'], 'correct' => 'Eager'],
            ['q' => 'Find the word that is most nearly OPPOSITE in meaning to: VAGUE', 'options' => ['Clear', 'Blurry', 'Uncertain', 'Dim', 'Hazy'], 'correct' => 'Clear'],
            ['q' => 'Light is to Dark as Joy is to:', 'options' => ['Sorrow', 'Happiness', 'Laughter', 'Bright', 'Play'], 'correct' => 'Sorrow'],
            ['q' => 'Pen is to Paper as Chalk is to:', 'options' => ['Blackboard', 'Pencil', 'Wood', 'Eraser', 'Dust'], 'correct' => 'Blackboard'],
            ['q' => 'The brave firefighter ________ the child from the burning building.', 'options' => ['rescued', 'ignored', 'pushed', 'called', 'watched'], 'correct' => 'rescued'],
            ['q' => 'Complete the analogy: Apple is to Fruit as Carrot is to:', 'options' => ['Vegetable', 'Root', 'Orange', 'Crunchy', 'Healthy'], 'correct' => 'Vegetable'],
            ['q' => 'Which word does NOT belong with the others?', 'options' => ['Eagle', 'Hawk', 'Penguin', 'Falcon', 'Owl'], 'correct' => 'Penguin'],
            ['q' => 'Choose the synonym for: ACCURATE', 'options' => ['Correct', 'Wrong', 'Vague', 'Fast', 'Messy'], 'correct' => 'Correct'],
        ];

        $nonVerbalQuestions = [
            ['q' => 'Which shape comes next in the sequence: Circle, Square, Circle, Square, ...?', 'options' => ['Circle', 'Triangle', 'Square', 'Star', 'Pentagon'], 'correct' => 'Circle'],
            ['q' => 'A large square contains a small circle. A large circle contains a:', 'options' => ['Small Square', 'Hexagon', 'Dot', 'Large Square', 'Line'], 'correct' => 'Small Square'],
            ['q' => 'Which figure corresponds to a 90-degree clockwise rotation of an "L" shape?', 'options' => ['Horizontal line', 'Upside down L', 'Sideways L', 'T-shape', 'Cross'], 'correct' => 'Sideways L'],
            ['q' => 'A pattern has three dots in a row, then three dots in a column. What is next?', 'options' => ['Three dots in a row', 'One dot', 'Circle of dots', 'Square of dots', 'Five dots'], 'correct' => 'Three dots in a row'],
            ['q' => 'Find the odd one out among these geometric patterns.', 'options' => ['Triangle', 'Square', 'Circle', 'Rectangle', 'Trapezoid'], 'correct' => 'Circle'],
        ];

        $samplePool = ($type === 'Verbal') ? $verbalQuestions : $nonVerbalQuestions;

        for ($i = 1; $i <= $count; $i++) {
            $sample = $samplePool[($i - 1) % count($samplePool)];
            
            $optionsData = [];
            foreach ($sample['options'] as $optText) {
                $optionsData[] = [
                    'text' => $optText,
                    'is_correct' => ($optText === $sample['correct'])
                ];
            }
            
            shuffle($optionsData);

            $section->questions()->create([
                'content' => "{$type} Analysis #{$i}: " . $sample['q'],
                'type' => 'multiple_choice',
                'points' => 1,
                'options' => $optionsData,
                'correct_answer' => $sample['correct'],
            ]);
        }
        
        $this->command->info("Created {$count} questions for {$section->title}.");
    }
}

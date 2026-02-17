<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Database\Seeder;

class Grade7ExamsSeeder extends Seeder
{
    public function run(): void
    {
        $this->createMathExam();
        $this->createEnglishExam();
        $this->createScienceExam();
        $this->createReasoningExam();
    }

    private function createMathExam()
    {
        $exam = Exam::create([
            'title' => 'Grade 7 Mathematics Aptitude Test',
            'description' => 'Comprehensive assessment of mathematical skills for Grade 7 entrants including Algebra, Geometry, and Number Sense.',
            'target_grade_level' => 'Grade 7',
            'time_limit' => 60,
            'active' => true,
        ]);

        $section = $exam->sections()->create([
            'title' => 'Arithmetic & Number Sense',
            'description' => 'Basic operations, fractions, and decimals.',
            'order' => 1,
        ]);

        $this->q($section, 'What is the sum of 1/4 and 2/5?', ['7/20', '3/9', '3/20', '13/20'], '13/20');
        $this->q($section, 'Solve: 15% of 200.', ['20', '30', '40', '15'], '30');
        $this->q($section, 'Which of the following is a prime number?', ['9', '15', '21', '23'], '23');

        $section2 = $exam->sections()->create([
            'title' => 'Introductory Algebra',
            'description' => 'Variables, expressions, and simple equations.',
            'order' => 2,
        ]);

        $this->q($section2, 'Evaluate 3x + 5 when x = 4.', ['12', '17', '9', '20'], '17');
        $this->q($section2, 'Solve for y: 2y - 10 = 30.', ['10', '15', '20', '25'], '20');
    }

    private function createEnglishExam()
    {
        $exam = Exam::create([
            'title' => 'Grade 7 English Proficiency Exam',
            'description' => 'Measures language skills in grammar, vocabulary, and reading comprehension.',
            'target_grade_level' => 'Grade 7',
            'time_limit' => 45,
            'active' => true,
        ]);

        $section = $exam->sections()->create([
            'title' => 'Grammar & Usage',
            'description' => 'Proper sentence structure and parts of speech.',
            'order' => 1,
        ]);

        $this->q($section, 'Choose the correct word: The students _____ going on a field trip.', ['is', 'are', 'was', 'be'], 'are');
        $this->q($section, 'Identify the adjective in: "The clever fox jumped over the fence."', ['clever', 'fox', 'jumped', 'fence'], 'clever');

        $section2 = $exam->sections()->create([
            'title' => 'Reading Comprehension',
            'description' => 'Understanding written passages.',
            'order' => 2,
        ]);

        $this->q($section2, 'In a story, the "protagonist" usually refers to the:', ['Villain', 'Main Character', 'Narrator', 'Setting'], 'Main Character');
    }

    private function createScienceExam()
    {
        $exam = Exam::create([
            'title' => 'Grade 7 Science & Environmental Awareness',
            'description' => 'Covers basics of Biology, Earth Science, and Physical Science for Junior High School.',
            'target_grade_level' => 'Grade 7',
            'time_limit' => 50,
            'active' => true,
        ]);

        $section = $exam->sections()->create([
            'title' => 'Life Science',
            'description' => 'Cells, plants, and human systems.',
            'order' => 1,
        ]);

        $this->q($section, 'The "Powerhouse of the Cell" is known as the:', ['Nucleus', 'Ribosome', 'Mitochondria', 'Cell Plate'], 'Mitochondria');
        $this->q($section, 'Which gas do plants primarily absorb during photosynthesis?', ['Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Helium'], 'Carbon Dioxide');

        $section2 = $exam->sections()->create([
            'title' => 'Earth & Environment',
            'description' => 'Climate, geology, and ecology.',
            'order' => 2,
        ]);

        $this->q($section2, 'What is the outermost layer of the Earth called?', ['Crust', 'Mantle', 'Outer Core', 'Inner Core'], 'Crust');
    }

    private function createReasoningExam()
    {
        $exam = Exam::create([
            'title' => 'Grade 7 Abstract Reasoning',
            'description' => 'Evaluation of non-verbal reasoning and pattern recognition.',
            'target_grade_level' => 'Grade 7',
            'time_limit' => 30,
            'active' => true,
        ]);

        $section = $exam->sections()->create([
            'title' => 'Sequence Reasoning',
            'description' => 'Identify the next item in a pattern.',
            'order' => 1,
        ]);

        $this->q($section, 'Which number comes next: 2, 4, 8, 16, ___?', ['20', '24', '32', '64'], '32');
        $this->q($section, 'Complete the series: 1, 3, 6, 10, ___?', ['15', '12', '18', '20'], '15');
    }

    private function q($section, $text, $options, $correct)
    {
        $optionsData = [];
        foreach ($options as $optText) {
            $optionsData[] = [
                'text' => $optText,
                'is_correct' => ($optText === $correct)
            ];
        }

        $section->questions()->create([
            'content' => $text,
            'type' => 'multiple_choice',
            'points' => 1,
            'options' => $optionsData,
            'correct_answer' => $correct,
        ]);
    }
}

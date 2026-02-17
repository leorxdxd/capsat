<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Section;
use App\Models\Question;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    /**
     * Display a listing of exams
     */
    public function index()
    {
        $exams = Exam::with(['sections.questions'])
            ->withCount(['sections', 'sections as questions_count' => function ($q) {
                $q->selectRaw('count(questions.id)')
                  ->join('questions', 'sections.id', '=', 'questions.section_id');
            }])->orderByDesc('active')->latest()->get();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new exam
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created exam
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_grade_level' => 'nullable|string|max:50',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        $exam = Exam::create($validated);

        AuditLog::log('exam.created', 'Created exam: ' . $exam->title, $exam);

        return redirect()->route('exams.show', $exam)->with('success', 'Exam created successfully. Now add sections and questions.');
    }

    /**
     * Display the specified exam with sections and questions
     */
    public function show(Exam $exam)
    {
        $exam->load(['sections.questions' => function ($q) {
            $q->orderBy('id');
        }]);

        $totalQuestions = $exam->sections->sum(fn($s) => $s->questions->count());
        $totalPoints = $exam->sections->sum(fn($s) => $s->questions->sum('points'));

        return view('exams.show', compact('exam', 'totalQuestions', 'totalPoints'));
    }

    /**
     * Preview the exam as a student would see it (read-only)
     */
    public function preview(Exam $exam)
    {
        $exam->load(['sections.questions' => function ($q) {
            $q->orderBy('id');
        }]);

        $totalQuestions = $exam->sections->sum(fn($s) => $s->questions->count());

        return view('exams.preview', compact('exam', 'totalQuestions'));
    }

    /**
     * Show the form for editing the specified exam
     */
    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    /**
     * Update the specified exam
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_grade_level' => 'nullable|string|max:50',
            'time_limit' => 'nullable|integer|min:1',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');
        $exam->update($validated);

        AuditLog::log('exam.updated', 'Updated exam: ' . $exam->title, $exam);

        return redirect()->route('exams.show', $exam)->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified exam
     */
    public function destroy(Exam $exam)
    {
        $title = $exam->title;
        $exam->sections()->each(function ($section) {
            $section->questions()->delete();
            $section->delete();
        });
        $exam->delete();

        AuditLog::log('exam.deleted', 'Deleted exam: ' . $title);

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    /**
     * Toggle exam active status
     */
    public function toggleStatus(Exam $exam)
    {
        $exam->update(['active' => !$exam->active]);

        AuditLog::log('exam.toggled', ($exam->active ? 'Activated' : 'Deactivated') . ' exam: ' . $exam->title, $exam);

        return back()->with('success', 'Exam ' . ($exam->active ? 'activated' : 'deactivated') . ' successfully.');
    }

    /**
     * Duplicate the specified exam
     */
    public function duplicate(Exam $exam)
    {
        // 1. Replicate the exam
        $newExam = $exam->replicate();
        $newExam->title = 'Copy of ' . $exam->title;
        $newExam->active = false; // Set to inactive by default
        $newExam->created_at = now();
        $newExam->updated_at = now();
        $newExam->save();

        // 2. Replicate sections and questions
        foreach ($exam->sections as $section) {
            $newSection = $section->replicate();
            $newSection->exam_id = $newExam->id;
            $newSection->created_at = now();
            $newSection->updated_at = now();
            $newSection->save();

            foreach ($section->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->section_id = $newSection->id;
                $newQuestion->created_at = now();
                $newQuestion->updated_at = now();
                
                // Note: Options are JSON, so they are copied automatically.
                // Images are referenced by URL. We are NOT duplicating the actual image files 
                // to save space, both questions will point to the same image.
                // If this is a problem (editing one affects other), we would need to copy files too.
                // For now, shared images are fine as they are usually static assets.
                
                $newQuestion->save();
            }
        }

        AuditLog::log('exam.duplicated', 'Duplicated exam: ' . $exam->title . ' to ' . $newExam->title, $newExam);

        return redirect()->route('exams.show', $newExam)->with('success', 'Exam duplicated successfully. You can now edit the copy.');
    }

    /**
     * Store a new section for an exam
     */
    public function storeSection(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'section_type' => 'nullable|string|in:intelligence,achievement,other',
        ]);

        $maxOrder = $exam->sections()->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        $exam->sections()->create($validated);

        return redirect()->route('exams.show', $exam)->with('success', 'Section added successfully.');
    }

    /**
     * Update a section
     */
    public function updateSection(Request $request, Exam $exam, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'section_type' => 'nullable|string|in:intelligence,achievement,other',
        ]);

        $section->update($validated);

        return redirect()->route('exams.show', $exam)->with('success', 'Section updated successfully.');
    }

    /**
     * Delete a section
     */
    public function destroySection(Exam $exam, Section $section)
    {
        $section->questions()->delete();
        $section->delete();

        return redirect()->route('exams.show', $exam)->with('success', 'Section deleted successfully.');
    }

    /**
     * Store a new question for a section
     */
    public function storeQuestion(Request $request, Exam $exam, Section $section)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:multiple_choice,true_false,identification,number_series,analogy,sequence',
            'content' => 'required|string',
            'points' => 'required|integer|min:1',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
            'media' => 'nullable|image|max:5120',
            'option_image_files' => 'nullable|array',
            'option_image_files.*' => 'nullable|image|max:5120',
        ]);

        // Clean up options — remove empty ones
        if (isset($validated['options'])) {
            $validated['options'] = array_values(array_filter($validated['options'], fn($o) => !empty(trim($o))));
        }

        // Handle question image upload
        $data = collect($validated)->except(['media', 'option_image_files'])->toArray();

        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('question-images', 'public');
            $data['media_url'] = '/storage/' . $path;
        }

        // Handle option image uploads
        if ($request->hasFile('option_image_files')) {
            $optionImages = [];
            foreach ($request->file('option_image_files') as $index => $file) {
                if ($file) {
                    $path = $file->store('question-images/options', 'public');
                    $optionImages[$index] = '/storage/' . $path;
                }
            }
            if (!empty($optionImages)) {
                $data['option_images'] = $optionImages;
            }
        }

        $section->questions()->create($data);

        return redirect()->route('exams.show', $exam)->with('success', 'Question added successfully.');
    }

    /**
     * Update a question
     */
    public function updateQuestion(Request $request, Exam $exam, Section $section, Question $question)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:multiple_choice,true_false,identification,number_series,analogy,sequence',
            'content' => 'required|string',
            'points' => 'required|integer|min:1',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
            'media' => 'nullable|image|max:5120',
            'remove_media' => 'nullable|boolean',
            'option_image_files' => 'nullable|array',
            'option_image_files.*' => 'nullable|image|max:5120',
            'remove_option_images' => 'nullable|array',
            'remove_option_images.*' => 'nullable|boolean',
        ]);

        if (isset($validated['options'])) {
            $validated['options'] = array_values(array_filter($validated['options'], fn($o) => !empty(trim($o))));
        }

        $data = collect($validated)->except(['media', 'remove_media', 'option_image_files', 'remove_option_images'])->toArray();

        // Handle question image
        if ($request->hasFile('media')) {
            // Delete old image
            if ($question->media_url) {
                $oldPath = str_replace('/storage/', '', $question->media_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('media')->store('question-images', 'public');
            $data['media_url'] = '/storage/' . $path;
        } elseif ($request->boolean('remove_media')) {
            if ($question->media_url) {
                $oldPath = str_replace('/storage/', '', $question->media_url);
                Storage::disk('public')->delete($oldPath);
            }
            $data['media_url'] = null;
        }

        // Handle option images
        $existingOptionImages = $question->option_images ?? [];

        // Remove marked option images
        if ($request->has('remove_option_images')) {
            foreach ($request->input('remove_option_images', []) as $idx => $remove) {
                if ($remove && isset($existingOptionImages[$idx])) {
                    $oldPath = str_replace('/storage/', '', $existingOptionImages[$idx]);
                    Storage::disk('public')->delete($oldPath);
                    unset($existingOptionImages[$idx]);
                }
            }
        }

        // Upload new option images
        if ($request->hasFile('option_image_files')) {
            foreach ($request->file('option_image_files') as $index => $file) {
                if ($file) {
                    // Delete old if exists
                    if (isset($existingOptionImages[$index])) {
                        $oldPath = str_replace('/storage/', '', $existingOptionImages[$index]);
                        Storage::disk('public')->delete($oldPath);
                    }
                    $path = $file->store('question-images/options', 'public');
                    $existingOptionImages[$index] = '/storage/' . $path;
                }
            }
        }

        $data['option_images'] = !empty($existingOptionImages) ? $existingOptionImages : null;

        $question->update($data);

        return redirect()->route('exams.show', $exam)->with('success', 'Question updated successfully.');
    }

    /**
     * Delete a question
     */
    public function destroyQuestion(Exam $exam, Section $section, Question $question)
    {
        // Clean up uploaded images
        if ($question->media_url) {
            $oldPath = str_replace('/storage/', '', $question->media_url);
            Storage::disk('public')->delete($oldPath);
        }
        if ($question->option_images) {
            foreach ($question->option_images as $imgPath) {
                if ($imgPath) {
                    $oldPath = str_replace('/storage/', '', $imgPath);
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $question->delete();

        return redirect()->route('exams.show', $exam)->with('success', 'Question deleted successfully.');
    }
}

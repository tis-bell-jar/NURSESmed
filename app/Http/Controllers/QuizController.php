<?php
// app/Http/Controllers/QuizController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\TextBreak;
use PhpOffice\PhpWord\Element\Link;

class QuizController extends Controller
{
    /**
     * Display the quiz form by extracting only question + four options (A–D) from the .docx,
     * and stripping out any “ticks” so nothing shows them to the user.
     */
    public function index(Request $request)
    {
        // 1) Validate required parameters
        $request->validate([
            'file'     => 'required|string',
            'category' => 'required|string',
            'section'  => 'required|string|in:paper_1,paper_2,pastpapers,predictions',
        ]);

        $filename = $request->query('file');
        $category = $request->query('category');
        $section  = $request->query('section');

        // 2) Build the relative storage path
        $relativePath = "nck/{$section}/{$category}/{$filename}";
        if (! Storage::disk('public')->exists($relativePath)) {
            abort(404, "Quiz file not found.");
        }

        // 3) Load the .docx via PhpWord
        $fullPath = storage_path("app/public/{$relativePath}");
        $phpWord  = IOFactory::load($fullPath);

        // 4) Extract _all_ raw text from every element in every section
        $allText = '';
        foreach ($phpWord->getSections() as $sectionObj) {
            foreach ($sectionObj->getElements() as $element) {
                $allText .= $this->extractTextFromElement($element) . "\n";
            }
        }

        // 5) Split into lines & parse exactly “Question X:” + four “A.”, “B.”, “C.”, “D.” options
        $lines = preg_split('/\r?\n/', $allText);

        $questions       = [];
        $currentQuestion = null;
        $collectingOpts  = false;
        $optionCount     = 0;

        foreach ($lines as $rawLine) {
            $line = trim($rawLine);
            if ($line === '') {
                continue;
            }

            // If a line begins with “Question 1:” (or 2:, 3:, …), start a new question block
            if (preg_match('/^Question\s*\d+\s*:/i', $line)) {
                // Push the previous question if it had exactly 4 options
                if ($currentQuestion !== null && count($currentQuestion['options']) === 4) {
                    $questions[] = $currentQuestion;
                }
                // Start a fresh question
                $currentQuestion = [
                    'prompt'  => '',
                    'options' => [],
                    'correct' => null,
                ];
                $collectingOpts = false;
                $optionCount    = 0;
                continue;
            }

            // While we have a $currentQuestion that is not yet collecting options:
            // Append lines to “prompt” until we see an “A. …” line
            if ($currentQuestion !== null && $optionCount === 0 && ! $collectingOpts) {
                if (preg_match('/^[A-D]\.\s*/i', $line)) {
                    // As soon as we see “A. …”, switch to collecting options mode
                    $collectingOpts = true;
                    // Fall through so we handle this same line as option “A”
                } else {
                    // Append this line to the question prompt (it might be multi‐line)
                    $currentQuestion['prompt'] .=
                        ($currentQuestion['prompt'] === '' ? $line : ' ' . $line);
                    continue;
                }
            }

            // If currently collecting exactly 4 options (A–D)
            if ($currentQuestion !== null && $collectingOpts && $optionCount < 4) {
                if (preg_match('/^([A-D])\.\s*(.*)$/i', $line, $m)) {
                    $letter = strtoupper($m[1]);
                    $rest   = $m[2];

                    // Detect and strip any common checkmarks wrapped in square brackets (or stand‐alone)
                    $isCorrect  = false;
                    $optTextRaw = $rest;
                    if (preg_match('/^\[(?:✓|✔|X|x|\/|√)\]\s*(.*)$/u', $rest, $m2)) {
                        $isCorrect  = true;
                        $optTextRaw = $m2[1];
                    }

                    $optTextClean = trim(
                        str_replace(
                            ['[✓]', '[✔]', '[X]', '[x]', '[/]', '[√]', '✓', '✔', 'X', 'x', '√'],
                            ['',     '',     '',     '',     '',      '',      '',   '',   '',   '',   ''],
                            $optTextRaw
                        )
                    );

                    if ($isCorrect) {
                        $currentQuestion['correct'] = $letter;
                    }
                    $currentQuestion['options'][$letter] = $optTextClean;
                    $optionCount++;

                    if ($optionCount === 4) {
                        $collectingOpts = false;
                    }
                    continue;
                }
            }

            if ($currentQuestion !== null && $optionCount === 4) {
                continue;
            }
        }

        if ($currentQuestion !== null && count($currentQuestion['options']) === 4) {
            $questions[] = $currentQuestion;
        }

        // ---- NURSE_X NUMBERING LOGIC ----
        $quizFolder = storage_path("app/public/nck/{$section}/{$category}");
        $files = glob($quizFolder . '/*');
        $files = array_map('basename', $files);
        sort($files); // if filenames have timestamps, this gives upload order

        $index = array_search($filename, $files);
        $displayName = $index !== false ? 'nurse_' . ($index + 1) : 'nurse_1';

        // 6) Return the “quiz” Blade with only question+options (no checkmarks shown)
        return view('quiz', [
            'filename'    => $filename,
            'displayName' => $displayName,
            'category'    => $category,
            'section'     => $section,
            'questions'   => $questions,
        ]);
    }

    /**
     * Grade the submitted quiz answers and show results.
     */
    public function submit(Request $request)
    {
        // 1) Validate form inputs
        $request->validate([
            'file'      => 'required|string',
            'category'  => 'required|string',
            'section'   => 'required|string|in:paper_1,paper_2,pastpapers,predictions',
            'answers'   => 'required|array',
            'answers.*' => 'in:A,B,C,D',
        ]);

        $filename    = $request->input('file');
        $category    = $request->input('category');
        $section     = $request->input('section');
        $userAnswers = $request->input('answers');

        $relativePath = "nck/{$section}/{$category}/{$filename}";
        if (! Storage::disk('public')->exists($relativePath)) {
            abort(404, "Quiz file not found.");
        }
        $fullPath = storage_path("app/public/{$relativePath}");
        $phpWord  = IOFactory::load($fullPath);

        $allText = '';
        foreach ($phpWord->getSections() as $sectionObj) {
            foreach ($sectionObj->getElements() as $element) {
                $allText .= $this->extractTextFromElement($element) . "\n";
            }
        }

        $lines = preg_split('/\r?\n/', $allText);

        $questions       = [];
        $currentQuestion = null;
        $collectingOpts  = false;
        $optionCount     = 0;

        foreach ($lines as $rawLine) {
            $line = trim($rawLine);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^Question\s*\d+\s*:/i', $line)) {
                if ($currentQuestion !== null && count($currentQuestion['options']) === 4) {
                    $questions[] = $currentQuestion;
                }
                $currentQuestion = [
                    'prompt'  => '',
                    'options' => [],
                    'correct' => null,
                ];
                $collectingOpts = false;
                $optionCount    = 0;
                continue;
            }

            if ($currentQuestion !== null && $optionCount === 0 && ! $collectingOpts) {
                if (preg_match('/^[A-D]\.\s*/i', $line)) {
                    $collectingOpts = true;
                } else {
                    $currentQuestion['prompt'] .=
                        ($currentQuestion['prompt'] === '' ? $line : ' ' . $line);
                    continue;
                }
            }

            if ($currentQuestion !== null && $collectingOpts && $optionCount < 4) {
                if (preg_match('/^([A-D])\.\s*(.*)$/i', $line, $m)) {
                    $letter = strtoupper($m[1]);
                    $rest   = $m[2];

                    $isCorrect  = false;
                    $optTextRaw = $rest;
                    if (preg_match('/^\[(?:✓|✔|X|x|\/|√)\]\s*(.*)$/u', $rest, $m2)) {
                        $isCorrect  = true;
                        $optTextRaw = $m2[1];
                    }

                    $optTextClean = trim(
                        str_replace(
                            ['[✓]', '[✔]', '[X]', '[x]', '[/]', '[√]', '✓', '✔', 'X', 'x', '√'],
                            ['',     '',     '',     '',     '',      '',      '',   '',   '',   '',   ''],
                            $optTextRaw
                        )
                    );

                    if ($isCorrect) {
                        $currentQuestion['correct'] = $letter;
                    }
                    $currentQuestion['options'][$letter] = $optTextClean;
                    $optionCount++;
                    if ($optionCount === 4) {
                        $collectingOpts = false;
                    }
                    continue;
                }
            }

            if ($currentQuestion !== null && $optionCount === 4) {
                continue;
            }
        }

        if ($currentQuestion !== null && count($currentQuestion['options']) === 4) {
            $questions[] = $currentQuestion;
        }

        // --- nurse_N numbering logic for results page, too ---
        $quizFolder = storage_path("app/public/nck/{$section}/{$category}");
        $files = glob($quizFolder . '/*');
        $files = array_map('basename', $files);
        sort($files);

        $index = array_search($filename, $files);
        $displayName = $index !== false ? 'nurse_' . ($index + 1) : 'nurse_1';

        // 3) Compare user answers vs. correct keys
        $totalQuestions = count($questions);
        $numCorrect     = 0;
        $feedback       = [];

        foreach ($questions as $idx => $q) {
            $correctKey = $q['correct'] ?? null;
            $userKey    = $userAnswers[$idx] ?? null;
            $isRight    = ($correctKey !== null && $userKey === $correctKey);
            if ($isRight) {
                $numCorrect++;
            }
            $feedback[] = [
                'prompt'     => $q['prompt'],
                'options'    => $q['options'],
                'correctKey' => $correctKey,
                'userKey'    => $userKey,
                'isCorrect'  => $isRight,
            ];
        }

        $scorePercent = $totalQuestions > 0
            ? round(($numCorrect / $totalQuestions) * 100, 1)
            : 0;

        // 4) Return a separate “quiz_results” view
        return view('quiz_results', [
            'filename'     => $filename,
            'displayName'  => $displayName,
            'category'     => $category,
            'section'      => $section,
            'total'        => $totalQuestions,
            'correctCount' => $numCorrect,
            'scorePercent' => $scorePercent,
            'feedback'     => $feedback,
        ]);
    }

    /**
     * Recursively extract plain text from any PhpWord element (Text, TextRun, TextBreak, Link).
     */
    private function extractTextFromElement($element): string
    {
        $text = '';

        if ($element instanceof Text) {
            $text .= $element->getText();
        }
        elseif ($element instanceof TextRun) {
            foreach ($element->getElements() as $child) {
                $text .= $this->extractTextFromElement($child);
            }
        }
        elseif ($element instanceof TextBreak) {
            $text .= "\n";
        }
        elseif ($element instanceof Link) {
            $text .= $element->getText();
        }

        return $text;
    }
}

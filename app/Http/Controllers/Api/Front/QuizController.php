<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCollection;
use App\Http\Resources\QuizResource;
use App\Models\QuizDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $quizzes = Quiz::query()->with('details')->paginate($request->per_page ?? 10);
        return response()->api([
            "quizzes" => (new QuizCollection($quizzes))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $quiz = Quiz::create([
                "code" => $request->code,
                "quiz_date" => $request->quiz_date,
                "name" => $request->name,
                "quiz_time" => $request->quiz_time,
            ]);

            $quiz->details()->createMany($request->questions);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        $quiz->load('details');

        return response()->api([
            'quiz' => new QuizResource($quiz)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load('details');
        return response()->api([
            'quiz' => new QuizResource($quiz)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        try {
            DB::beginTransaction();
            $quiz->update([
                "code" => $request->code,
                "quiz_date" => $request->quiz_date,
                "name" => $request->name,
                "quiz_time" => $request->quiz_time,
            ]);

            $quiz->details()->delete();
            $quiz->details()->createMany($request->questions);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        $quiz->load('details');

        return response()->api([
            'quiz' => new QuizResource($quiz)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();
            $quiz->details()->delete();
            $quiz->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->api();
    }
}

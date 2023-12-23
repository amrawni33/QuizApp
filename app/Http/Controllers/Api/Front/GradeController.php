<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $grades = Grade::query()
            ->with(['user', 'quiz'])
            ->paginate($request->per_page ?? 10);
        return response()->api([
            "grades" => (new GradeCollection($grades))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $validatedData = $request->validated();
        $grade = Grade::create($validatedData);
        $grade->load(['user', 'quiz']);

        return response()->api([
            'grade' => new GradeResource($grade)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $grade->load(['user', 'quiz']);

        return response()->api([
            'grade' => new GradeResource($grade)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $validatedData = $request->validated();
        $grade->update($validatedData);
        $grade->load(['user', 'quiz']);

        return response()->api([
            'grade' => new GradeResource($grade)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return response()->api();
    }
}

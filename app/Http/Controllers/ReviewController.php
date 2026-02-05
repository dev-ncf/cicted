<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Submission $submission)
    {
        //
        // dd(data)
         $data = $request->except('_token');
          dd($data);

    // 📌 CALCULAR TOTAL AUTOMATICAMENTE
    $user = User::find($submission->author_id);
    $data['score_total'] =
        (int)$request->score_intro +
        (int)$request->score_objectives +
        (int)$request->score_methodology +
        (int)$request->score_results +
        (int)$request->score_conclusions +
        (int)$request->score_keywords +
        (int)$request->score_style;

    if ($request->hasFile('reviewer_file')) {
        $file = $request->file('reviewer_file');
        $filename = 'review_' . $user->name. '.' . $file->getClientOriginalExtension();
        $data['reviewer_file'] = $file->storeAs('reviews', $filename, 'public');
    }

    Review::create($data);

    return back()->with('success', 'Avaliação registada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}

<?php

use App\Http\Controllers\CandidatesController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function()
{
    return View::make('pages.home');
});


Route::group(['prefix' => 'employer'], function () {
    Route::get('/',[EmployerController::class,'index'])->name('employer.index');
    Route::post('/create',[EmployerController::class,'createJob'])->name('employer.create.job');
    Route::get('/get_data', [EmployerController::class, 'getData'])->name('get.data');
    Route::get('/get_job',[EmployerController::class,'getJobData'])->name('get.job_data');
    Route::get('/get_candidate_details',[EmployerController::class,'getCandidateDetails'])->name('get.candidate.details');
});


Route::group(['prefix' => 'candidates'], function () {
    Route::get('/',[CandidatesController::class,'index'])->name('candidates.index');
    Route::post('/apply_job',[CandidatesController::class,'applyJob'])->name('apply.job');
});
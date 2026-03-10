<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    WelcomeController,
    PagesController,
    AdminController,
    LanguageController,
    ByNameController,
    HistoryController,
    ResultsController,
    CompareResultsController,
    PropertiesController,
    SpectrumController,
    BySubstructureController,
    ByShiftNoPositionController,
    ByCarbonTypeController,
    AnaliticaController,
    UploadExcelController,
    ConfigController,
    UsersController,
    LogsController,
    AdminSearchController,
    AdminLastMolController,
    AdminConfirmController,
    AdminMolEditController
};
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('locale/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/', [WelcomeController::class, 'home']);
Route::get('developers', [PagesController::class, 'developers']);
Route::get('conditions', [PagesController::class, 'conditions']);
Route::get('acknowledgment', [PagesController::class, 'acknow']);
Route::get('help', [PagesController::class, 'help']);
Route::get('contributors', [PagesController::class, 'contributors']);
Route::get('about', [PagesController::class, 'about']);
Route::get('contact', [PagesController::class, 'contact']);
Route::get('normalizedb', [AdminController::class, 'normalizedb']);

Route::middleware('auth')->group(function () {
    Route::get('search/byName', [ByNameController::class, 'get']);
    Route::post('search/byName', [ByNameController::class, 'post']);
    Route::post('history', [HistoryController::class, 'post']);
    Route::get('results/{history}', [ResultsController::class, 'get'])->name('mol.results');
    Route::get('results/{history}/selected', [CompareResultsController::class, 'get'])->name('mol.Compare');
    Route::get('properties/{id}', [PropertiesController::class, 'get'])->name('mol.properties');
    Route::get('spectrum/{id}', [SpectrumController::class, 'get'])->name('mol.spectrum');
    Route::get('search/bySubstructure', [BySubstructureController::class, 'get']);
    Route::post('search/bySubstructure', [BySubstructureController::class, 'post']);
    Route::get('search/byShiftNoPosition', [ByShiftNoPositionController::class, 'get']);
    Route::post('search/byShiftNoPosition', [ByShiftNoPositionController::class, 'post']);
    Route::get('search/byCarbonType', [ByCarbonTypeController::class, 'get']);
    Route::post('search/byCarbonType', [ByCarbonTypeController::class, 'post']);
    Route::get('history', [HistoryController::class, 'get']);
    Route::get('analitica/{history}', [AnaliticaController::class, 'get'])->name('mol.analitica');
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('spectrum/{id}/molecule3d', [SpectrumController::class, 'molecule3d']);

});

// admin routes
Route::prefix('admin')->middleware('adminCheck')->group(function () {
    Route::get('/', [AdminController::class, 'get']);
    Route::get('upload', [UploadExcelController::class, 'get']);
    Route::post('upload', [UploadExcelController::class, 'post']);
    
    Route::get('config', [ConfigController::class, 'get']);
    Route::get('users', [UsersController::class, 'get']);
    Route::delete('users/{id}', [UsersController::class, 'destroy']);
    Route::get('users/show/{id}', [UsersController::class, 'show']);
    Route::get('logs/{fileName?}', [LogsController::class, 'get']);
    Route::get('logs/download/{fileName}', [LogsController::class, 'download']);
    Route::get('logs/delete/{fileName}', [LogsController::class, 'delete']);
    
    Route::get('search', [AdminSearchController::class, 'get']);
    Route::post('search', [AdminSearchController::class, 'post']);
    Route::delete('search', [AdminSearchController::class, 'destroy']);
    
    Route::get('lastMolecules', [AdminLastMolController::class, 'get']);
    
    Route::get('confirm/{molId?}', [AdminConfirmController::class, 'get']);
    Route::post('confirm', [AdminConfirmController::class, 'post']);
    
    Route::get('molEdit/{molId?}', [AdminMolEditController::class, 'get']);
    Route::post('molEdit/{molId?}', [AdminMolEditController::class, 'post']);
    Route::get('/molecule/{id}/image', [ResultsController::class, 'image'])->name('molecule.image');
    Route::get('/molecule/{id}/properties', [ResultsController::class, 'properties'])->name('molecule.properties');
    Route::get('/molecule/{id}/spectrum', [ResultsController::class, 'spectrum'])->name('molecule.spectrum');
    Route::get('/molecule/{id}/doi', [ResultsController::class, 'doi'])->name('molecule.doi');
    
});

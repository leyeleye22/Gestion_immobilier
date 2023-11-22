<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BienvenuController;
use App\Http\Controllers\CommentaireController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BienvenuController::class, 'index']);



Route::get('/dashboard', [UsersController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/admin', [BienController::class, 'indexfirst'])->middleware(['admin'])->name('admin.dashboard');

Route::middleware('admin')->group(function () {
    Route::get('/ajout/bien', [BienController::class, 'index'])->name('admin.ajoutbien');
    Route::get('/detail/produit/{id}', [BienController::class, 'create']);
    Route::post('/savebien', [BienController::class, 'store']);
    Route::post('/update/bien/{id}', [BienController::class, 'update']);
    Route::get('/commentaire/admin/suppression/{commentaire}', [BienController::class, 'deletes']);

    Route::get('/back', function () {
        return redirect('/dashboard/admin');
    });
    Route::get('/delete/produit/{id}', [BienController::class, 'delete']);
    Route::get('/modifier/produit/{id}', [BienController::class, 'edit']);
});

Route::middleware('auth')->group(function () {
    
    Route::get('/delete/user/{id}', [UsersController::class, 'delete']);
    Route::get(' /listeuser', [UsersController::class, 'showUsers']);
    Route::get('/voir/details/{id}', [BienController::class, 'showdetailsBien']);
    Route::post('/commentaire/modif/{commentaire}', [CommentaireController::class, 'update']);
    Route::get('/commentaire/modifier/{iduser}/{commentaire}', [CommentaireController::class, 'edit']);
    Route::get('/commentaire/suppression/{iduser}/{commentaire}', [CommentaireController::class, 'destroy']);
    Route::get('/details/commentaires/{id1}/{id2}', [CommentaireController::class, 'show']);
    Route::post('/commentaire/{id1}/{id2}', [CommentaireController::class, 'store']);
    Route::get('/commentaire/{id}', [CommentaireController::class, 'create']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/subscribe', function (Request $request) {
    $validatedData = $request->validate([
        'email' => 'required|email',
    ]);

    $email = $validatedData['email'];

    Mail::raw('Salut Vous êtes inscrit !', function ($message) use ($email) {
        $message->to($email)->subject('Bienvenue Sur Notre Plateforme!');
    });

    return redirect()->back()->with('message', 'E-mail envoyé avec succès !');
});
require __DIR__ . '/auth.php';

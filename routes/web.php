<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RelatorioVeiculo;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Livewire\ManutencaoMaquina;
use App\Http\Livewire\ManutencaoVeiculo;
use App\Http\Livewire\Maquinas;
use App\Http\Livewire\Perfil;
use App\Http\Livewire\Usuarios;
use App\Http\Livewire\Veiculos;
use Illuminate\Support\Facades\Route;

Route::get('/gerar-pdf', [PdfController::class, ]);
Route::get('/', [LoginController::class, 'render'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login',[LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [RegisterController::class, 'render'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('create-register');
Route::get('/reset-password', [ResetpasswordController::class, 'render'])->name('reset-render');
Route::post('/reset-password', [ResetpasswordController::class, 'resetPassword'])->name('reset-password');


Route::middleware('auth')->prefix('dashboard')->group(function(){
    Route::get('/', [DashboardController::class, 'render'])->name('painel');
    Route::get('/usuarios', Usuarios::class)->name('usuarios');
    Route::get('/veiculos', Veiculos::class)->name('veiculos');
    Route::get('/veiculos/manutencao', ManutencaoVeiculo::class)->name('manutencao-veiculos');
    Route::get('/maquinas', Maquinas::class)->name('maquinas');
    Route::get('/maquinas/manutencao', ManutencaoMaquina::class)->name('manutencao-maquinas');
    Route::get('/perfil', Perfil::class)->name('perfil');
    Route::put('/perfil', [Perfil::class, 'update'])->name('update');
    Route::put('/perfil/update-password', [Perfil::class, 'updatePassword'])->name('update-password');

    // RELATÓRIOS VEÍCULOS
    Route::get('/relatorios/veiculos', [RelatorioVeiculo::class, 'render'])->name('relatorio-veiculo');
    Route::post('/relarios/veiculos/status', [RelatorioVeiculo::class, 'veiculoStatus'])->name('veiculos-status');
    Route::post('/relatorios/veiculos/manutencoes', [RelatorioVeiculo::class, 'manutencoesVeiculo'])->name('manutencoes-veiculo');
    
});






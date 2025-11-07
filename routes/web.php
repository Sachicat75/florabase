<?php

use App\Livewire\DashboardStats;
use App\Livewire\Families\FamiliesIndex;
use App\Livewire\Families\FamilyForm;
use App\Livewire\Families\FamilyShow;
use App\Livewire\Genera\GeneraIndex;
use App\Livewire\Genera\GenusForm;
use App\Livewire\Genera\GenusShow;
use App\Livewire\Locations\LocationForm;
use App\Livewire\Locations\LocationsIndex;
use App\Livewire\Plants\PlantForm;
use App\Livewire\Plants\PlantShow;
use App\Livewire\Plants\PlantsIndex;
use App\Livewire\Propagations\PropagationForm;
use App\Livewire\Propagations\PropagationShow;
use App\Livewire\Propagations\PropagationsIndex;
use App\Livewire\Seeds\SeedForm;
use App\Livewire\Seeds\SeedShow;
use App\Livewire\Seeds\SeedsIndex;
use App\Livewire\Subfamilies\SubfamiliesIndex;
use App\Livewire\Subfamilies\SubfamilyForm;
use App\Livewire\Subfamilies\SubfamilyShow;
use App\Livewire\Vendors\VendorForm;
use App\Livewire\Vendors\VendorsIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardStats::class)->name('dashboard');

    Route::get('/families', FamiliesIndex::class)->name('families.index');
    Route::get('/families/create', FamilyForm::class)->name('families.create');
    Route::get('/families/{family}', FamilyShow::class)->name('families.show');
    Route::get('/families/{family}/edit', FamilyForm::class)->name('families.edit');

    Route::get('/subfamilies', SubfamiliesIndex::class)->name('subfamilies.index');
    Route::get('/subfamilies/create', SubfamilyForm::class)->name('subfamilies.create');
    Route::get('/subfamilies/{subfamily}', SubfamilyShow::class)->name('subfamilies.show');
    Route::get('/subfamilies/{subfamily}/edit', SubfamilyForm::class)->name('subfamilies.edit');

    Route::get('/genera', GeneraIndex::class)->name('genera.index');
    Route::get('/genera/create', GenusForm::class)->name('genera.create');
    Route::get('/genera/{genus}', GenusShow::class)->name('genera.show');
    Route::get('/genera/{genus}/edit', GenusForm::class)->name('genera.edit');

    Route::get('/plants', PlantsIndex::class)->name('plants.index');
    Route::get('/plants/create', PlantForm::class)->name('plants.create');
    Route::get('/plants/{plant}', PlantShow::class)->name('plants.show');
    Route::get('/plants/{plant}/edit', PlantForm::class)->name('plants.edit');

    Route::get('/propagations', PropagationsIndex::class)->name('propagations.index');
    Route::get('/propagations/create', PropagationForm::class)->name('propagations.create');
    Route::get('/propagations/{propagation}', PropagationShow::class)->name('propagations.show');
    Route::get('/propagations/{propagation}/edit', PropagationForm::class)->name('propagations.edit');

    Route::get('/vendors', VendorsIndex::class)->name('vendors.index');
    Route::get('/vendors/create', VendorForm::class)->name('vendors.create');
    Route::get('/vendors/{vendor}/edit', VendorForm::class)->name('vendors.edit');

    Route::get('/locations', LocationsIndex::class)->name('locations.index');
    Route::get('/locations/create', LocationForm::class)->name('locations.create');
    Route::get('/locations/{location}/edit', LocationForm::class)->name('locations.edit');

    Route::get('/seeds', SeedsIndex::class)->name('seeds.index');
    Route::get('/seeds/create', SeedForm::class)->name('seeds.create');
    Route::get('/seeds/{seed}', SeedShow::class)->name('seeds.show');
    Route::get('/seeds/{seed}/edit', SeedForm::class)->name('seeds.edit');

    Route::view('/user/profile', 'user.profile')->name('user.profile');
    Route::view('/user/security', 'user.security')->name('user.security');
});

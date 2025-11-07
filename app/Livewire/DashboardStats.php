<?php

namespace App\Livewire;

use App\Models\Family;
use App\Models\Genus;
use App\Models\Location;
use App\Models\Plant;
use App\Models\Propagation;
use App\Models\Seed;
use App\Models\Subfamily;
use App\Models\Vendor;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $stats = [
            'families' => Family::where('user_id', $userId)->count(),
            'subfamilies' => Subfamily::where('user_id', $userId)->count(),
            'genera' => Genus::where('user_id', $userId)->count(),
            'plants' => Plant::where('user_id', $userId)->count(),
            'propagations' => Propagation::where('user_id', $userId)->count(),
            'vendors' => Vendor::where('user_id', $userId)->count(),
            'locations' => Location::where('user_id', $userId)->count(),
            'seeds' => Seed::where('user_id', $userId)->count(),
            'collection_value' => (float) Plant::where('user_id', $userId)->sum('purchase_price'),
        ];

        return view('livewire.dashboard-stats', [
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}

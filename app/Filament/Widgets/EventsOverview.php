<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Events',Event::where('status', 'Active')->count())->chart([3, 5, 8, 1, 11, 7, 15])->color('success'),
            Stat::make('Users',User::count())->chart([3, 5, 8, 1, 11, 7, 15])->color('success'),
            Stat::make('Roles',Event::count())->chart([3, 5, 8, 1, 11, 7, 15])->color('success')

        ];
    }
}

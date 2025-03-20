<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
enum ProjectStatusEnum: string implements HasLabel, HasColor
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Blocked = 'blocked';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    
    public function getLabel(): string{
        return match($this){
            self::Open => 'Open',
            self::InProgress => 'In Progress',
            self::Blocked => 'Blocked',
            self::Cancelled => 'Cancelled',
            self::Completed => 'Completed',
        };
    }

    public function getColor(): string{
        return match($this){
            self::Open => 'primary',
            self::InProgress => 'warning',
            self::Blocked => 'danger',
            self::Cancelled => 'secondary',
            self::Completed => 'success',
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasColor;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
enum UserStatusEnum: string implements HasLabel, HasDescription, HasColor
{

    case Pending = 'pending';
    case Enable = 'enable';
    case Disable = 'disable';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Enable => 'Enable',
            self::Disable => 'Disable',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Enable => 'Enable',
            self::Disable => 'Disable',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'info',
            self::Enable => 'success',
            self::Disable => 'danger',
        };
    }
}

<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Classes\UserClass;
// use Filament\Actions\Action;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;

class ListUser extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    public $users = [];
    public function usersQuery()
    {
        return (new UserClass())->getAllUserList();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->usersQuery())
            ->selectable()
            ->columns([
                SpatieMediaLibraryImageColumn::make("profile_media")->collection("profile_media")->label('Profile'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email'),
                TextColumn::make('phone'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('edit')
                        ->label('Edit User')
                        ->icon('heroicon-o-pencil')
                        ->color('bg-red-500')
                        ->url(function ($record) {
                            return route('dashboard_v2_user_edit', ['uuid' => $record->uuid]);
                        }),
                    Action::make('delete')
                        ->requiresConfirmation()
                        ->label('Delete User')
                        ->icon('heroicon-o-trash')
                        ->color('bg-red-500')
                        ->action(fn(User $record) => $record->delete())
                ])->button(),
            ]);
    }
    public function deleteUser(User $record)
    {
        $record->delete();

        Notification::make()
            ->title('User Deleted')
            ->body('The user has been deleted successfully.')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dashboard.users.list-user');
    }
}

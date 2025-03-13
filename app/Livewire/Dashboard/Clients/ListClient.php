<?php

namespace App\Livewire\Dashboard\Clients;

use App\Classes\ClientClass;
use Livewire\Component;
use App\Models\Client;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;

class ListClient extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public $users = [];
    public function clientQuery()
    {
        return (new ClientClass())->getAllClientList();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->clientQuery())
            ->selectable()
            ->columns([
                // SpatieMediaLibraryImageColumn::make("profile_media")->collection("profile_media")->label('Profile'),
                TextColumn::make('contact_name')->searchable(),
                TextColumn::make('contact_email'),
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
                            return route('dashboard_v2_client_edit', ['uuid' => $record->uuid]);
                        }),
                    Action::make('delete')
                        ->requiresConfirmation()
                        ->label('Delete Client')
                        ->icon('heroicon-o-trash')
                        ->color('bg-red-500')
                        ->action(fn(Client $record) => $record->delete())
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
        return view('livewire.dashboard.clients.list-client');
    }
}

<?php
namespace App\Livewire\Dashboard\Clients;

use App\Classes\ClientClass;
use App\Models\Client;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

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
                TextColumn::make('contact_name'),
                TextColumn::make('contact_email'),
                TextColumn::make('phone'),
            ])
            ->filters([
                Filter::make('contact_name')
                    ->form([
                        TextInput::make('contact_name')
                            ->label('Search Client Name')
                            ->placeholder('Search by Client Name...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['contact_name'],
                            fn(Builder $query, $title): Builder => $query->where('contact_name', 'like', '%' . $title . '%')
                        );

                    }),

                TrashedFilter::make()
                    ->label("Trashed Records"),

            ], layout: FiltersLayout::AboveContent)
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
                        ->action(fn(Client $record) => $record->delete()),
                ])->button(),
            ])->bulkActions([
            DeleteBulkAction::make()
                ->label('Delete Bulk Clients'),
            ForceDeleteBulkAction::make()
                ->label('Force Delete Bulk Clients'),
            RestoreBulkAction::make()
                ->label('Restore Bulk Clients'),
        ]);
    }
    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View The view for the Livewire component.
     */
    public function render()
    {
        return view('livewire.dashboard.clients.list-client');
    }
}

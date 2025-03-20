<?php
namespace App\Livewire\Dashboard\Projects;

use App\Classes\ProjectClass;
use App\Enums\ProjectStatusEnum;
use App\Models\Client;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListProject extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public $projects = [];
    public function projectQuery()
    {
        return (new ProjectClass())->getAllPorjectList();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->projectQuery())
            ->selectable()
            ->columns([
                TextColumn::make('title')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                TextColumn::make('user.name')->label('Assign To'),
                TextColumn::make('client.contact_name')->label('Client'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(function ($record): string {
                        return $record->status->getLabel();
                    })
                    ->color(function ($record): string {
                        return $record->status->getColor();
                    }),
                TextColumn::make('deadline_at')->date(),
            ])->defaultSort('created_at', 'DESC')
            ->filters([
                Filter::make('title')
                    ->form([
                        TextInput::make('title')
                            ->label('Search Title')
                            ->placeholder('Search by Project title...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['title'],
                            fn(Builder $query, $title): Builder => $query->where('title', 'like', '%' . $title . '%')
                        );
                    }),
                SelectFilter::make('status')
                    ->options(
                        ProjectStatusEnum::class,
                    ),
                SelectFilter::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),
                SelectFilter::make('client_id')
                    ->label('Client')
                    ->options(Client::pluck('contact_name', 'id'))
                    ->searchable(),
                TrashedFilter::make()
                    ->label('Trashed Records'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Action::make('edit')
                        ->label('Edit Project')
                        ->icon('heroicon-o-pencil')
                        ->color('bg-red-500')
                        ->url(function ($record) {
                            return route('dashboard_v2_project_edit', ['uuid' => $record->uuid]);
                        }),
                    DeleteAction::make()
                        ->label('Delete Project'),
                    RestoreAction::make()
                        ->label('Restore Project'),
                    ForceDeleteAction::make()
                        ->label('Force Delete Project'),
                ])->button(),
            ])->bulkActions([
            DeleteBulkAction::make()
                ->label('Delete Bulk Project'),
            ForceDeleteBulkAction::make()
                ->label('Force Delete Bulk Project'),
            RestoreBulkAction::make()
                ->label('Restore Bulk Project'),
        ]);
    }
    public function render()
    {
        return view('livewire.dashboard.projects.list-project');
    }

}

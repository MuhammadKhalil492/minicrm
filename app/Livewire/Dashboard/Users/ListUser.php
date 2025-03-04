<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Classes\UserClass;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;

class ListUser extends Component implements HasTable,HasForms
{
    use InteractsWithTable, InteractsWithForms;
    public $users=[];
    public function usersQuery(){
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
               ->url(function($record){
                    return route('dashboard_v2_user_edit',['uuid' => $record->uuid]);
                })
              ])  
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.dashboard.users.list-user');
    }
}

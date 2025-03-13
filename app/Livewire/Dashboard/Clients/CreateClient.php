<?php

namespace App\Livewire\Dashboard\Clients;

use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Classes\ClientClass;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Split;

class CreateClient extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    /**
     * This function is responsible for mounting the component and filling the form with data.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        TextInput::make('contact_name')
                            ->label('Name')
                            ->minLength(4)
                            ->columnSpanFull()
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->required()
                            ->rules('min:4|max:255')
                            ->email()
                            ->columnSpanFull()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->columnSpanFull()
                            ->maxLength(255),
                    ])->columns(6),
                    Section::make([
                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->minLength(4)
                            ->maxLength(30)
                            ->columnSpan(6)
                            ->required(),
                        TextInput::make('company_vat')
                            ->label('Company Vat')
                            ->required()
                            ->columnSpan(6)
                            ->numeric()
                            ->maxLength(255),
                        TextInput::make('company_address')
                            ->label('Address')
                            ->required()
                            ->columnSpan(6)
                            ->rules('min:4|max:30')
                            ->maxLength(255),
                        TextInput::make('company_city')
                            ->label('City')
                            ->columnSpan(6)
                            ->maxLength(255),
                        TextInput::make('company_zip')
                            ->label('Postal Code')
                            ->numeric()
                            ->columnSpan(6)
                            ->maxLength(255),
                    ])->columns(6),
                ])->from('sm')
            ])->statePath('data')
            ->model(Client::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        try {
            DB::beginTransaction();
            $client = (new ClientClass())->saveClient($data);
            Notification::make()
                ->title('Client created successfully')
                ->success()
                ->send();
            DB::commit();
            redirect()->to(route('dashboard_v2_clients'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make()
                ->title('Error creating client')
                ->body($th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.clients.create-client');
    }
}

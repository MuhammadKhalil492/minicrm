<?php

namespace App\Livewire\Dashboard\Users;

use App\Enums\UserStatusEnum;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Classes\UserClass;
use Filament\Notifications\Notification;


class CreateUser extends Component implements HasForms
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
                Grid::make()
                    ->columns([
                        'default' => 1,
                        'lg' => 10, // Adjusting to a 10-column grid for 70/30 split
                    ])
                    ->schema([
                        Group::make()
                            ->columnSpan(['lg' => 10]) // Change to 7 for 70%
                            ->schema([
                                Section::make('Personal Information')
                                    ->schema([
                                        TextInput::make('meta.first_name')
                                            ->label('First Name *')
                                            ->minLength(4)
                                            ->maxLength(30)
                                            ->inlineLabel()
                                            ->rules('required|min:4|max:30'),
                                        TextInput::make('meta.last_name')
                                            ->label('Last Name *')
                                            ->rules('required|min:4|max:30')
                                            ->inlineLabel()
                                            ->minLength(4)
                                            ->maxLength(30),
                                        TextInput::make('email')
                                            ->label('Email *')
                                            ->rules('required|min:4|max:30')
                                            ->email()
                                            ->inlineLabel()
                                            ->maxLength(255),
                                        TextInput::make('meta.phone')
                                            ->inlineLabel()
                                            ->maxLength(255),
                                        Select::make('meta.status')
                                            ->label('Status *')
                                            ->rules('required|min:4|max:30')
                                            ->options(UserStatusEnum::class)
                                            ->inlineLabel(),
                                        Checkbox::make('meta.send_email')->label('Send Email'),
                                    ]),
                            ]),
                    ])
            ])->statePath('data')
            ->model(User::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['name'] = $data['meta']['first_name'] . ' ' . $data['meta']['last_name'];
        $password = Str::random(10);
        $data['password'] = Hash::make($password);
        try {
            DB::beginTransaction();
            $user = (new UserClass())->saveUser($data);
            if ($user) {
                (new UserClass())->saveUserMeta($user, $data['meta']);
            }
            Notification::make()
                ->title('User created successfully')
                ->success()
                ->send();
            DB::commit();
            redirect()->to(route('dashboard_v2_users'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make()
                ->title('Error creating user')
                ->body($th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.users.create-user');
    }
}

<?php

namespace App\Livewire\Dashboard\Users;

use App\Classes\UserClass;
use App\Models\User;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Enums\UserStatusEnum;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class EditUser extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public User $user;

    public function mount(string $uuid): void
    {
        $this->user = User::findByUuidOrFail($uuid);
        $user = $this->user;
        $formData = $user->toArray();
        $formData['meta'] = (new UserClass())->getMetaFields($user);
        $this->form->fill($formData);
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns([
                        'default' => 1,
                        'lg' => 10
                    ])
                    ->schema([
                        Group::make()
                            ->columnSpan(9)
                            ->schema([
                                Section::make('Information')
                                    ->schema([
                                        TextInput::make('meta.first_name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columns(10),
                                        TextInput::make('meta.last_name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columns(10),
                                        TextInput::make('email')
                                            ->required(function () {
                                                return request()->routeIs('dashboard_v2_add_user') || request()->routeIs('filament.admin.resources.user.create');
                                            })
                                            ->disabled(
                                                function () {
                                                    return request()->routeIs('dashboard_v2_user_edit') || request()->routeIs('filament.admin.resources.user.edit');
                                                }
                                            )
                                            ->email()
                                            ->maxLength(255)
                                            ->columns(10),
                                        TextInput::make('meta.phone')
                                            ->maxLength(255)
                                            ->columns(10),
                                        Select::make('meta.status')
                                            ->required()
                                            ->options(UserStatusEnum::class)
                                            ->columns(10),

                                    ]),
                                Section::make('Change Password')
                                    ->schema([
                                        TextInput::make('password')
                                            ->confirmed()
                                            ->password()
                                            ->inlineLabel()
                                            ->maxLength(255),
                                        TextInput::make('password_confirmation')
                                            ->password()
                                            ->inlineLabel()
                                            ->maxLength(255),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(3)
                            ->schema([
                                Section::make('Profile Image')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('profile_media')
                                            ->collection('profile_media')
                                            ->label('')
                                            ->avatar()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])->loadingIndicatorPosition('left'),

                                    ])->columnSpan(2),
                            ]),
                    ])
                    ->columns(12),
            ])->statePath('data')
            ->model($this->user);
    }
    public function update(): void
    {
        $data = $this->form->getState();
        $user = $this->user;
        $userId = $user->id;
        $meta = $data['meta'];
        $data['name'] = $meta['first_name'] . ' ' . $meta['last_name'];
        $data['password'] = !empty($data['password'])  ? Hash::make($data['password']) : $user->password;
        try {
            DB::beginTransaction();
            $user = (new UserClass())->saveUser($data, $userId);
            if ($user) {
                (new UserClass())->saveUserMeta($user, $data['meta']);
            }
            DB::commit();
            Notification::make()
                ->title('Update User Successfully')
                ->success()
                ->color('success')
                ->send();
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make()
                ->title('Could not update listing.' . $th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.users.edit-user');
    }
}

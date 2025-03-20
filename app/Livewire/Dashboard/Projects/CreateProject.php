<?php
namespace App\Livewire\Dashboard\Projects;

use App\Classes\ProjectClass;
use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateProject extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Project $project;
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
                Section::make('Project Details')->schema([
                    TextInput::make('title')
                        ->minLength(4)
                        ->columnSpan(4)
                        ->maxLength(50)
                        ->required(),
                    Select::make('status')
                        ->options(ProjectStatusEnum::class)
                        ->columnSpan(4),
                    DatePicker::make('deadline_at')
                        ->label('Deadline')
                        ->columnSpan(4),
                    RichEditor::make('description')
                        ->columnSpanFull(),
                    Select::make('user_id')
                        ->options(function () {
                            return \App\Models\User::all()->pluck('name', 'id');
                        })
                        ->required()
                        ->label('Users')
                        ->preload()
                        ->searchable()
                        ->columnSpan(6),
                    Select::make('client_id')
                        ->required()
                        ->options(function () {
                            return \App\Models\Client::all()->pluck('contact_name', 'id');
                        })
                        ->preload()
                        ->searchable()
                        ->columnSpan(6),
                ])->columns(12),
            ])->statePath('data')
            ->model(Project::class);
    }
    public function create(): void
    {
        $data = $this->form->getState();
        try {
            DB::beginTransaction();
            $project = (new ProjectClass())->saveProject($data);
            if ($project) {
                $this->form->model($project)->saveRelationships();
            }
            Notification::make()
                ->title('Project created successfully')
                ->success()
                ->send();
            DB::commit();
            redirect()->to(route('dashboard_v2_projects'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make()
                ->title('Error creating Project')
                ->body($th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }

    public function cancel()
    {
        return redirect()->to(route('dashboard_v2_projects'));
    }
    public function render()
    {
        return view('livewire.dashboard.projects.create-project');
    }
}

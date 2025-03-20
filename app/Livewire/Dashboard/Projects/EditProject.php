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

class EditProject extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Project $project;
    /**
     * This function is responsible for mounting the component and filling the form with data.
     *
     * @return void
     */
    public function mount(string $uuid): void
    {
        $this->project = Project::findByUuidOrFail($uuid);
        $project = $this->project;
        $formData = $project->toArray();
        $this->form->fill($formData);
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
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->preload()
                        ->searchable()
                        ->columnSpan(6),
                    Select::make('client_id')
                        ->relationship(name: 'client', titleAttribute: 'contact_name')
                        ->preload()
                        ->searchable()
                        ->columnSpan(6),
                ])->columns(12),
            ])->statePath('data')
            ->model($this->project);
    }
    public function update(): void
    {
        $data       = $this->form->getState();
        $project_id = $this->project->id;
        try {
            DB::beginTransaction();
            $project = (new ProjectClass())->saveProject($data, $project_id);
            if ($project) {
                $this->form->model($project)->saveRelationships();
            }
            Notification::make()
                ->title('Project updated successfully')
                ->success()
                ->send();
            DB::commit();
            redirect()->to(route('dashboard_v2_projects'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make()
                ->title('Error updating Project')
                ->body($th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }

    public function  cancel()
    {
        return redirect()->to(route('dashboard_v2_projects'));
    }
    public function render()
    {
        return view('livewire.dashboard.projects.edit-project');
    }
}

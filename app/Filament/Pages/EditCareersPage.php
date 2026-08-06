<?php

namespace App\Filament\Pages;

use App\Models\CareersPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditCareersPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Careers Page';

    protected static ?string $title = 'Careers Page';

    protected static string $view = 'filament.pages.edit-careers-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(CareersPage::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('heading')->required(),
                Forms\Components\Section::make('Intro text')
                    ->schema([
                        Forms\Components\RichEditor::make('intro_text')->label(''),
                    ]),
                Forms\Components\Section::make('Contact')
                    ->schema([
                        Forms\Components\TextInput::make('contact_name'),
                        Forms\Components\TextInput::make('contact_phone'),
                        Forms\Components\TextInput::make('contact_email')->email(),
                    ])->columns(3),
                Forms\Components\Section::make('Application form')
                    ->schema([
                        Forms\Components\Select::make('application_form_id')
                            ->label('Driver application form')
                            ->options(fn () => FormModel::query()->pluck('name', 'id'))
                            ->helperText('The form shown at the bottom of this page. Edit its fields under Forms.'),
                    ]),
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title'),
                        Forms\Components\Textarea::make('meta_description')->rows(2),
                    ])->collapsed(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        CareersPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

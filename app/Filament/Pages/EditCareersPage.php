<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Models\CareersPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditCareersPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Careers Page';

    protected static ?string $title = 'Careers Page';

    protected string $view = 'filament.pages.edit-careers-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(CareersPage::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('heading')->required(),
                Section::make('Intro text')
                    ->schema([
                        RichEditor::make('intro_text')->label(''),
                    ]),
                Section::make('Contact')
                    ->schema([
                        TextInput::make('contact_name'),
                        TextInput::make('contact_phone'),
                        TextInput::make('contact_email')->email(),
                    ])->columns(3),
                Section::make('Application form')
                    ->schema([
                        Select::make('application_form_id')
                            ->label('Driver application form')
                            ->options(fn () => FormModel::query()->pluck('name', 'id'))
                            ->helperText('The form shown at the bottom of this page. Edit its fields under Forms.'),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description')->rows(2),
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

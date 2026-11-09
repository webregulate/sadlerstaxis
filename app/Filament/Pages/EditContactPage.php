<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Models\ContactPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditContactPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Contact Page';

    protected static ?string $title = 'Contact Page';

    protected string $view = 'filament.pages.edit-contact-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ContactPage::current()->toArray());
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
                Section::make('Form')
                    ->schema([
                        Select::make('contact_form_id')
                            ->label('Contact form')
                            ->options(fn () => FormModel::query()->pluck('name', 'id'))
                            ->helperText('The form shown on this page. Edit its fields under Forms.'),
                    ]),
                Section::make('Office')
                    ->schema([
                        TextInput::make('map_embed_url')
                            ->label('Google Maps embed URL')
                            ->helperText('Paste the "src" URL from a Google Maps embed iframe.'),
                        Textarea::make('office_address')->rows(2),
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
        ContactPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

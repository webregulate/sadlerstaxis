<?php

namespace App\Filament\Pages;

use App\Models\ContactPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditContactPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Contact Page';

    protected static ?string $title = 'Contact Page';

    protected static string $view = 'filament.pages.edit-contact-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ContactPage::current()->toArray());
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
                Forms\Components\Section::make('Form')
                    ->schema([
                        Forms\Components\Select::make('contact_form_id')
                            ->label('Contact form')
                            ->options(fn () => FormModel::query()->pluck('name', 'id'))
                            ->helperText('The form shown on this page. Edit its fields under Forms.'),
                    ]),
                Forms\Components\Section::make('Office')
                    ->schema([
                        Forms\Components\TextInput::make('map_embed_url')
                            ->label('Google Maps embed URL')
                            ->helperText('Paste the "src" URL from a Google Maps embed iframe.'),
                        Forms\Components\Textarea::make('office_address')->rows(2),
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
        ContactPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

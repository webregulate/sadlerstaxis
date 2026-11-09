<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditAboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'About Us Page';

    protected static ?string $title = 'About Us Page';

    protected string $view = 'filament.pages.edit-about-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutPage::current()->toArray());
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
                Section::make('History')
                    ->schema([
                        TextInput::make('history_heading')->label('Heading'),
                        RichEditor::make('history_text')->label('Text'),
                    ]),
                Section::make('History photo gallery')
                    ->description('Historic photos shown alongside the History text.')
                    ->schema([
                        Repeater::make('history_gallery')
                            ->label('Photos')
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('media/about-history')
                                    ->required(),
                                TextInput::make('caption')
                                    ->label('Caption'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add photo')
                            ->defaultItems(0),
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
        AboutPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

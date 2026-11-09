<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use App\Models\HomePage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditHomePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Home Page';

    protected static ?string $title = 'Home Page';

    protected string $view = 'filament.pages.edit-home-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(HomePage::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('hero_heading')->required(),
                        TextInput::make('hero_subheading'),
                        FileUpload::make('hero_image_path')
                            ->label('Hero image')
                            ->image()
                            ->disk('public')
                            ->directory('media'),
                    ]),
                Section::make('Welcome text')
                    ->schema([
                        RichEditor::make('intro_text')->label(''),
                    ]),
                Section::make('Highlight cards')
                    ->schema([
                        Repeater::make('highlights')
                            ->schema([
                                TextInput::make('title')->required(),
                                Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add highlight')
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
        HomePage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

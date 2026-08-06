<?php

namespace App\Filament\Pages;

use App\Models\HomePage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditHomePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Home Page';

    protected static ?string $title = 'Home Page';

    protected static string $view = 'filament.pages.edit-home-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(HomePage::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero')
                    ->schema([
                        Forms\Components\TextInput::make('hero_heading')->required(),
                        Forms\Components\TextInput::make('hero_subheading'),
                        Forms\Components\FileUpload::make('hero_image_path')
                            ->label('Hero image')
                            ->image()
                            ->disk('public')
                            ->directory('media'),
                    ]),
                Forms\Components\Section::make('Welcome text')
                    ->schema([
                        Forms\Components\RichEditor::make('intro_text')->label(''),
                    ]),
                Forms\Components\Section::make('Highlight cards')
                    ->schema([
                        Forms\Components\Repeater::make('highlights')
                            ->schema([
                                Forms\Components\TextInput::make('title')->required(),
                                Forms\Components\Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add highlight')
                            ->defaultItems(0),
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
        HomePage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

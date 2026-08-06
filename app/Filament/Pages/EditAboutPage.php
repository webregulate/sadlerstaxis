<?php

namespace App\Filament\Pages;

use App\Models\AboutPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditAboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'About Us Page';

    protected static ?string $title = 'About Us Page';

    protected static string $view = 'filament.pages.edit-about-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutPage::current()->toArray());
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
                Forms\Components\Section::make('History')
                    ->schema([
                        Forms\Components\TextInput::make('history_heading')->label('Heading'),
                        Forms\Components\RichEditor::make('history_text')->label('Text'),
                    ]),
                Forms\Components\Section::make('History photo gallery')
                    ->description('Historic photos shown alongside the History text.')
                    ->schema([
                        Forms\Components\Repeater::make('history_gallery')
                            ->label('Photos')
                            ->schema([
                                Forms\Components\FileUpload::make('path')
                                    ->label('Photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('media/about-history')
                                    ->required(),
                                Forms\Components\TextInput::make('caption')
                                    ->label('Caption'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add photo')
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
        AboutPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

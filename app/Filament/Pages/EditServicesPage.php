<?php

namespace App\Filament\Pages;

use App\Models\ServicesPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditServicesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Services Page';

    protected static ?string $title = 'Services Page';

    protected static string $view = 'filament.pages.edit-services-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ServicesPage::current()->toArray());
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
                Forms\Components\Section::make('Services')
                    ->schema([
                        Forms\Components\Repeater::make('services')
                            ->schema([
                                Forms\Components\TextInput::make('title')->required(),
                                Forms\Components\Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add service')
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
        ServicesPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use App\Models\ServicesPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditServicesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Services Page';

    protected static ?string $title = 'Services Page';

    protected string $view = 'filament.pages.edit-services-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ServicesPage::current()->toArray());
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
                Section::make('Services')
                    ->schema([
                        Repeater::make('services')
                            ->schema([
                                TextInput::make('title')->required(),
                                Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add service')
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
        ServicesPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

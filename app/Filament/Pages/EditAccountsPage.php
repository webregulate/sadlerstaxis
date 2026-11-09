<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Models\AccountsPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditAccountsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Accounts Page';

    protected static ?string $title = 'Accounts Page';

    protected string $view = 'filament.pages.edit-accounts-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AccountsPage::current()->toArray());
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
                Section::make('Benefits')
                    ->schema([
                        Repeater::make('benefits')
                            ->schema([
                                TextInput::make('title')->required(),
                                Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add benefit')
                            ->defaultItems(0),
                    ]),
                Section::make('Invoicing terms')
                    ->schema([
                        RichEditor::make('terms_text')->label(''),
                    ]),
                Section::make('Application form')
                    ->schema([
                        Select::make('new_account_form_id')
                            ->label('New account application form')
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
        AccountsPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

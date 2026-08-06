<?php

namespace App\Filament\Pages;

use App\Models\AccountsPage;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditAccountsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Accounts Page';

    protected static ?string $title = 'Accounts Page';

    protected static string $view = 'filament.pages.edit-accounts-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AccountsPage::current()->toArray());
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
                Forms\Components\Section::make('Benefits')
                    ->schema([
                        Forms\Components\Repeater::make('benefits')
                            ->schema([
                                Forms\Components\TextInput::make('title')->required(),
                                Forms\Components\Textarea::make('description')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add benefit')
                            ->defaultItems(0),
                    ]),
                Forms\Components\Section::make('Invoicing terms')
                    ->schema([
                        Forms\Components\RichEditor::make('terms_text')->label(''),
                    ]),
                Forms\Components\Section::make('Application form')
                    ->schema([
                        Forms\Components\Select::make('new_account_form_id')
                            ->label('New account application form')
                            ->options(fn () => FormModel::query()->pluck('name', 'id'))
                            ->helperText('The form shown at the bottom of this page. Edit its fields under Forms.'),
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
        AccountsPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

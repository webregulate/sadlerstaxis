<?php

namespace App\Filament\Pages;

use App\Models\PrivacyPolicyPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditPrivacyPolicyPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Privacy Policy Page';

    protected static ?string $title = 'Privacy Policy Page';

    protected static string $view = 'filament.pages.edit-privacy-policy-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(PrivacyPolicyPage::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('heading')->required(),
                Forms\Components\DatePicker::make('last_updated'),
                Forms\Components\RichEditor::make('content')->label('Content'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PrivacyPolicyPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

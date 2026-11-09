<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use App\Models\PrivacyPolicyPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditPrivacyPolicyPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static string | \UnitEnum | null $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Privacy Policy Page';

    protected static ?string $title = 'Privacy Policy Page';

    protected string $view = 'filament.pages.edit-privacy-policy-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(PrivacyPolicyPage::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('heading')->required(),
                DatePicker::make('last_updated'),
                RichEditor::make('content')->label('Content'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PrivacyPolicyPage::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

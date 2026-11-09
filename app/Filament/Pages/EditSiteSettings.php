<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected string $view = 'filament.pages.edit-site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General')
                    ->description('The name, tagline, and logo shown in the header.')
                    ->schema([
                        TextInput::make('site_name')->required(),
                        TextInput::make('tagline'),
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('media')
                            ->helperText('Optional. If left blank, the site name is shown as text instead.'),
                    ]),
                Section::make('Warning banner')
                    ->description('Shown as a strip across the very top of every page.')
                    ->schema([
                        Toggle::make('show_warning_banner')
                            ->label('Show marshal warning banner'),
                        Textarea::make('warning_banner')
                            ->label('Warning banner text')
                            ->rows(3),
                    ]),
                Section::make('Contact')
                    ->schema([
                        TextInput::make('primary_phone')
                            ->label('Primary phone number (shown in header)'),
                        TextInput::make('email')->email(),
                    ])->columns(2),
                Section::make('Office / area phone numbers')
                    ->description('Shown in the footer and on the Contact page, one entry per area.')
                    ->schema([
                        Repeater::make('phone_areas')
                            ->label('Areas')
                            ->schema([
                                TextInput::make('areaName')->label('Area')->required(),
                                TextInput::make('phoneNumbers')
                                    ->label('Phone number(s)')
                                    ->helperText('e.g. "020 8500 7777 / 020 8501 2222" if more than one')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add area')
                            ->defaultItems(0),
                    ]),
                Section::make('External links')
                    ->schema([
                        TextInput::make('book_online_url')->label('Online booking system URL'),
                        TextInput::make('account_booking_url')->label('Corporate account booking URL'),
                        TextInput::make('ios_app_url')->label('iPhone / iPad app URL'),
                        TextInput::make('android_app_url')->label('Android app URL'),
                    ])->columns(2),
                TextInput::make('footer_copyright_name')->label('Footer copyright name'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected static string $view = 'filament.pages.edit-site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General')
                    ->description('The name, tagline, and logo shown in the header.')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')->required(),
                        Forms\Components\TextInput::make('tagline'),
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('media')
                            ->helperText('Optional. If left blank, the site name is shown as text instead.'),
                    ]),
                Forms\Components\Section::make('Warning banner')
                    ->description('Shown as a strip across the very top of every page.')
                    ->schema([
                        Forms\Components\Toggle::make('show_warning_banner')
                            ->label('Show marshal warning banner'),
                        Forms\Components\Textarea::make('warning_banner')
                            ->label('Warning banner text')
                            ->rows(3),
                    ]),
                Forms\Components\Section::make('Contact')
                    ->schema([
                        Forms\Components\TextInput::make('primary_phone')
                            ->label('Primary phone number (shown in header)'),
                        Forms\Components\TextInput::make('email')->email(),
                    ])->columns(2),
                Forms\Components\Section::make('Office / area phone numbers')
                    ->description('Shown in the footer and on the Contact page, one entry per area.')
                    ->schema([
                        Forms\Components\Repeater::make('phone_areas')
                            ->label('Areas')
                            ->schema([
                                Forms\Components\TextInput::make('areaName')->label('Area')->required(),
                                Forms\Components\TextInput::make('phoneNumbers')
                                    ->label('Phone number(s)')
                                    ->helperText('e.g. "020 8500 7777 / 020 8501 2222" if more than one')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add area')
                            ->defaultItems(0),
                    ]),
                Forms\Components\Section::make('External links')
                    ->schema([
                        Forms\Components\TextInput::make('book_online_url')->label('Online booking system URL'),
                        Forms\Components\TextInput::make('account_booking_url')->label('Corporate account booking URL'),
                        Forms\Components\TextInput::make('ios_app_url')->label('iPhone / iPad app URL'),
                        Forms\Components\TextInput::make('android_app_url')->label('Android app URL'),
                    ])->columns(2),
                Forms\Components\TextInput::make('footer_copyright_name')->label('Footer copyright name'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()->title('Saved')->success()->send();
    }
}

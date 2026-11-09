<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use App\Filament\Resources\FormResource\Pages\ListForms;
use App\Filament\Resources\FormResource\Pages\CreateForm;
use App\Filament\Resources\FormResource\Pages\EditForm;
use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Forms';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form details')
                    ->schema([
                        TextInput::make('name')
                            ->helperText('Internal name shown in this list, e.g. "Contact Form".')
                            ->required(),
                        TextInput::make('submit_button_label')
                            ->default('Submit')
                            ->required(),
                    ])->columns(2),
                Section::make('Fields')
                    ->description('Every field shown on the public form, in order. "Name" is used internally and must be unique within this form (letters, numbers, underscores only).')
                    ->schema([
                        Repeater::make('fields')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('label')
                                            ->required()
                                            ->columnSpan(2),
                                        Select::make('type')
                                            ->options([
                                                'text' => 'Text',
                                                'email' => 'Email',
                                                'textarea' => 'Textarea',
                                                'select' => 'Dropdown',
                                                'checkbox' => 'Checkbox',
                                                'heading' => 'Section heading (no input)',
                                            ])
                                            ->default('text')
                                            ->required()
                                            ->live()
                                            ->columnSpan(1),
                                        Toggle::make('required')
                                            ->columnSpan(1),
                                    ]),
                                TextInput::make('name')
                                    ->helperText('e.g. company_name — no spaces.')
                                    ->required(fn (Get $get) => $get('type') !== 'heading')
                                    ->visible(fn (Get $get) => $get('type') !== 'heading'),
                                Repeater::make('options')
                                    ->schema([
                                        TextInput::make('label')->required(),
                                        TextInput::make('value')->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Add option')
                                    ->visible(fn (Get $get) => $get('type') === 'select'),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Field')
                            ->addActionLabel('Add field')
                            ->collapsed()
                            ->reorderableWithButtons(),
                    ]),
                Section::make('Confirmation')
                    ->schema([
                        Textarea::make('confirmation_message')
                            ->label('Confirmation message shown after submitting')
                            ->rows(2),
                    ]),
                Section::make('Email notification')
                    ->description('Sent to your inbox every time this form is submitted. Use {{field_name}} in the subject/message to include a submitted value.')
                    ->schema([
                        TextInput::make('notify_email')
                            ->label('Send notification to')
                            ->email()
                            ->required(),
                        TextInput::make('subject_template')
                            ->label('Email subject')
                            ->required(),
                        Textarea::make('message_template')
                            ->label('Email message')
                            ->rows(4)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('notify_email')->label('Notifies'),
                TextColumn::make('submissions_count')
                    ->label('Submissions')
                    ->counts('submissions'),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }
}

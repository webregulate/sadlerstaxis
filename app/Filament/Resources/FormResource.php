<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->helperText('Internal name shown in this list, e.g. "Contact Form".')
                            ->required(),
                        Forms\Components\TextInput::make('submit_button_label')
                            ->default('Submit')
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Fields')
                    ->description('Every field shown on the public form, in order. "Name" is used internally and must be unique within this form (letters, numbers, underscores only).')
                    ->schema([
                        Forms\Components\Repeater::make('fields')
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->required()
                                            ->columnSpan(2),
                                        Forms\Components\Select::make('type')
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
                                        Forms\Components\Toggle::make('required')
                                            ->columnSpan(1),
                                    ]),
                                Forms\Components\TextInput::make('name')
                                    ->helperText('e.g. company_name — no spaces.')
                                    ->required(fn (Get $get) => $get('type') !== 'heading')
                                    ->visible(fn (Get $get) => $get('type') !== 'heading'),
                                Forms\Components\Repeater::make('options')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')->required(),
                                        Forms\Components\TextInput::make('value')->required(),
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
                Forms\Components\Section::make('Confirmation')
                    ->schema([
                        Forms\Components\Textarea::make('confirmation_message')
                            ->label('Confirmation message shown after submitting')
                            ->rows(2),
                    ]),
                Forms\Components\Section::make('Email notification')
                    ->description('Sent to your inbox every time this form is submitted. Use {{field_name}} in the subject/message to include a submitted value.')
                    ->schema([
                        Forms\Components\TextInput::make('notify_email')
                            ->label('Send notification to')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('subject_template')
                            ->label('Email subject')
                            ->required(),
                        Forms\Components\Textarea::make('message_template')
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
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('notify_email')->label('Notifies'),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->label('Submissions')
                    ->counts('submissions'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}

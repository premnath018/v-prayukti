<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'Content Management System';


    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                TextInput::make('name')
                    ->label('Event Name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image_url')
                    ->label('Image Upload')
                    ->image() // Ensures the file is an image
                    ->disk('public') // Save the file to the 'public' disk
                    ->directory('events/images') // Folder where the image will be stored
                    ->visibility('public') // Make the image publicly accessible
                    ->required(),
                TextInput::make('form_url')
                    ->label('Form URL')
                    ->url()
                    ->maxLength(2048),
                Select::make('type')
                    ->label('Event Type')
                    ->options([
                        'Technical' => 'Technical',
                        'Non Technical' => 'Non Technical',
                        'Workshops' => 'Workshops',
                    ])
                    ->native(false)
                    ->required(),
                TextInput::make('rulebook_url')
                    ->label('Rulebook URL')
                    ->url()
                    ->maxLength(2048),
                TextInput::make('problem_url')
                    ->label('Problem URL')
                    ->url()
                    ->maxLength(2048),
                TextInput::make('tag')
                    ->label('Tag')
                    ->maxLength(255),
                TextInput::make('fee')
                    ->label('Fee')
                    ->maxLength(50),
                DatePicker::make('deadline')
                    ->label('Deadline'),
                TextInput::make('team_count')
                    ->label('Team Count')
                    ->maxLength(50),
                Textarea::make('team_formation')
                    ->label('Team Formation'),
                Textarea::make('domain')
                    ->label('Domain'),
                Textarea::make('introduction')
                    ->label('Introduction'),
                Textarea::make('description')
                    ->label('Description'),
                Textarea::make('info')
                    ->label('Info'),
                Textarea::make('eligibility')
                    ->label('Eligibility'),
                Textarea::make('faculty_contacts')
                    ->label('Faculty Contacts')
                    ->json(),
                Textarea::make('student_contacts')
                    ->label('Student Contacts')
                    ->json(),
                TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email()
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->native(false)
                    ->default('Active'),
                ])->columns(2)
            ]);
    }

   
public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            TextColumn::make('id')
                ->label('Event ID')
                ->sortable()
                ->searchable(),
            TextColumn::make('name')
                ->label('Event Name')
                ->sortable()
                ->searchable(),
            TextColumn::make('type')
                ->label('Type')
                ->sortable()
                ->searchable(),
            TextColumn::make('fee')
                ->label('Fee'),
            TextColumn::make('deadline')
                ->label('Deadline')
                ->date(),
            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Active' => 'success',
                    'Inactive' => 'danger',
                }),
            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime(),
            TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('type')
                ->label('Type')
                ->options([
                    'Technical' => 'Technical',
                    'Non Technical' => 'Non Technical',
                    'Workshops' => 'Workshops',
                ]),
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'Active' => 'Active',
                    'Inactive' => 'Inactive',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $navigationGroup = 'Konten';
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required()->minLength(10),
            FileUpload::make('image')
                ->disk('public')
                ->directory('news_images')
                ->image()
                ->required(),
            Textarea::make('content')->required()->rows(10),
            TextInput::make('author_id')
                ->default(fn () => auth()->id())
                ->hiddenOn('edit'),
            DateTimePicker::make('published_at')
                ->default(now())
                ->required(),
        ]);
    }

     public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('image')->disk('public'),
            Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
            Tables\Columns\TextColumn::make('author.name')->label('Author'),
            Tables\Columns\TextColumn::make('published_at')->dateTime(),
        ])->defaultSort('published_at', 'desc');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}

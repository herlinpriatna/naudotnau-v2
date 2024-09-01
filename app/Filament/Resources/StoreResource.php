<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Nama Toko
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nama Toko'),

            // Alamat Toko
            Forms\Components\Textarea::make('address')
                ->required()
                ->label('Alamat Toko'),

            // Nomor Telepon
            Forms\Components\TextInput::make('phone_number')
                ->required()
                ->maxLength(20)
                ->label('Nomor Telepon'),

            // Media Sosial (Array)
            Forms\Components\Repeater::make('social_media')
                ->schema([
                    Forms\Components\TextInput::make('platform')
                        ->label('Platform'),
                    Forms\Components\TextInput::make('link')
                        ->label('Link'),
                ])
                ->label('Media Sosial'),

            // Gambar Toko
            Forms\Components\FileUpload::make('image')
                ->disk('public') // Disk penyimpanan
                ->directory('store-images') // Direktori penyimpanan
                ->image() // Hanya izinkan gambar
                ->label('Gambar Toko')
                ->maxSize(10 * 1024), // Maksimal 10MB

            // Tautan Peta
            Forms\Components\TextInput::make('map_link')
                ->url()
                ->label('Tautan Peta'),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Kolom Nama Toko
            Tables\Columns\TextColumn::make('name')
                ->label('Nama Toko')
                ->sortable()
                ->searchable(),

            // Kolom Alamat Toko
            Tables\Columns\TextColumn::make('address')
                ->label('Alamat Toko')
                ->limit(50) // Batas panjang teks alamat untuk ditampilkan
                ->sortable(),

            // Kolom Nomor Telepon
            Tables\Columns\TextColumn::make('phone_number')
                ->label('Nomor Telepon')
                ->sortable(),

            // // Kolom Media Sosial (Gabungkan media sosial menjadi string)
            // Tables\Columns\TextColumn::make('social_media')
            //     ->label('Media Sosial')
            //     ->formatStateUsing(fn ($state) => collect($state)->map(fn ($item) => $item['platform'] . ': ' . $item['link'])->join(', ')) // Gabungkan menjadi string
            //     ->limit(100) // Batas panjang teks media sosial
            //     ->sortable(),

            // // Kolom Gambar Toko (Menampilkan gambar sebagai preview)
            // Tables\Columns\ImageColumn::make('image')
            //     ->disk('public') // Disk penyimpanan gambar
            //     ->label('Gambar Toko')
            //     ->size(100), // Ukuran gambar di tabel

            // Kolom Tautan Peta
            Tables\Columns\TextColumn::make('map_link')
                ->label('Tautan Peta')
                // Tampilkan sebagai URL
                ->sortable(),
        ])
        ->filters([
            // Tambahkan filter jika diperlukan
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}

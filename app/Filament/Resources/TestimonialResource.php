<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                ->label('Gambar')
                ->image() // Mengatur agar hanya file gambar yang bisa diunggah
                ->directory('testimonials') // Direktori penyimpanan untuk gambar
                ->nullable(),

            Textarea::make('testimony')
                ->label('Testimoni')
                ->required()
                ->rows(4),

            TextInput::make('name')
                ->label('Nama')
                ->required(),

            Select::make('rate')
                ->label('Rating')
                ->options([
                    1 => '1 Bintang',
                    2 => '2 Bintang',
                    3 => '3 Bintang',
                    4 => '4 Bintang',
                    5 => '5 Bintang',
                ])
                ->default(5)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name') // Menampilkan nama
                ->label('Nama')
                ->sortable()
                ->searchable(), // Menambahkan kemampuan pencarian

            Tables\Columns\ImageColumn::make('image') // Menampilkan gambar
                ->label('Gambar')
                ->size(50)
                ->circular() // Mengatur ukuran gambar
                ->sortable(),

            Tables\Columns\TextColumn::make('testimony') // Menampilkan isi testimoni
                ->label('Testimoni')
                ->sortable()
                ->limit(50), // Membatasi jumlah karakter yang ditampilkan

            Tables\Columns\TextColumn::make('rate') // Menampilkan rating
                ->label('Rating')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at') // Menampilkan tanggal dibuat
                ->label('Tanggal Dibuat')
                ->dateTime(), // Format tanggal dan waktu
        ])
        ->filters([
            // Anda bisa menambahkan filter jika diperlukan
        ])
        ->actions([
            Tables\Actions\EditAction::make(), // Aksi untuk mengedit testimonial
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(), // Aksi untuk menghapus testimonial secara massal
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}

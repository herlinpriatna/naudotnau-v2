<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductVariation;

use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Nama Produk
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nama Produk'),
    
                // Deskripsi Produk
            Forms\Components\Textarea::make('description')
                ->required()
                ->label('Deskripsi Produk'),
    
                // Bahan Produk
            Forms\Components\TextInput::make('material')
                ->required()
                ->maxLength(255)
                ->label('Bahan'),

                // Harga Minimum
            Forms\Components\TextInput::make('price_min')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label('Harga Minimum'),
    
                // Harga Maksimum
            Forms\Components\TextInput::make('price_max')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label('Harga Maksimum'),
    
                // Ukuran Produk (Relasi Many-to-Many dengan ProductSize)
            Forms\Components\Select::make('sizes')
                ->multiple()
                ->relationship('sizes', 'name')
                ->preload()
                ->options(ProductSize::pluck('name', 'id')->toArray())
                ->label('Ukuran'),
            
            Forms\Components\Select::make('variations')
                ->multiple()
                ->relationship('variations', 'name')
                ->preload()
                ->options(ProductVariation::pluck('name', 'id')->toArray())
                ->label('Variasi'),
    
            // Stok Produk
            Forms\Components\TextInput::make('stock')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label('Stok'),

            Forms\Components\Select::make('stores')
                ->multiple()
                ->relationship('stores', 'name')
                ->preload()
                ->options(Store::pluck('name', 'id')->toArray())
                ->label('Toko'),

            Forms\Components\TextInput::make('link_shopee')
                ->maxLength(255)
                ->label('Link Shopee (Opsional)'),

            Forms\Components\TextInput::make('link_tiktok')
                ->maxLength(255)
                ->label('Link Tiktok (Opsional)'),

            Forms\Components\Repeater::make('images')
                ->label('Upload Gambar Produk')
                ->required()
                ->maxItems(5) // Maksimal 5 gambar
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->image()
                        ->required() // Setiap gambar diperlukan
                        ->maxSize(2048) // Ukuran maksimal 2MB
                        ->preserveFilenames(),
                ]),
            

        ]);
    }


    public static function create(CreateProduct $request): Product
    {
        $data = $request->validated();

        // Menangani upload gambar
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('product-images', 'public'); // Simpan gambar di folder 'product-images' dalam storage/public
            }
            $data['images'] = json_encode($images); // Simpan dalam format JSON
        }

        // Buat produk baru
        $product = Product::create($data);

        if (isset($data['sizes']) && isset($data['variations']) && isset($data['stores'])) {
            foreach ($data['sizes'] as $sizeId) {
                foreach ($data['variations'] as $variationId) {
                    foreach ($data['stores'] as $storeId) {
                        $product->sizes()->attach($sizeId, ['product_variation_id' => $variationId, 'store_id' => $storeId]);
                    }
                }
            }
        }
        return $product;
    }

   


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Nama Produk
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),

                // Kolom Deskripsi Produk
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi Produk')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),

                // Kolom Bahan Produk
                Tables\Columns\TextColumn::make('material')
                    ->label('Bahan')
                    ->sortable()
                    ->searchable(),

                // Kolom Ukuran Produk
                Tables\Columns\TextColumn::make('sizes.name')
                    ->label('Ukuran')
                    ->formatStateUsing(fn ($state) => collect($state)->join(', '))
                    ->sortable(),

                // Kolom Variasi Produk
                Tables\Columns\TextColumn::make('variations.name')
                    ->label('Variasi')
                    ->formatStateUsing(fn ($state) => collect($state)->join(', '))
                    ->sortable(),

                // Kolom Toko Produk
                Tables\Columns\TextColumn::make('stores.name')
                    ->label('Toko')
                    ->formatStateUsing(fn ($state) => collect($state)->join(', '))
                    ->sortable(),

                    Tables\Columns\ImageColumn::make('images')
                    ->label('Gambar Produk')
                    ->circular()
                    ->size(50)
                    ->getStateUsing(function ($record) {
                        if (is_string($record->images)) { // Periksa jika itu adalah string
                            $images = json_decode($record->images, true);
                            return $images[0] ?? null; // Mengambil gambar pertama atau null jika tidak ada gambar
                        }
                        return null; // Jika tidak dalam bentuk string, kembalikan null
                    }),
            ])
            ->filters([
                // Tambahkan filter jika perlu
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
            // Add relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

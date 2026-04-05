<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->components([
                        Section::make('Thông tin cơ bản')
                            ->components([
                                Select::make('category_id')
                                    ->label('Danh mục')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Tên danh mục')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Set $set) => 
                                                $set('slug', Str::slug($state))
                                            ),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                TextInput::make('name')
                                    ->label('Tên sản phẩm')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                    ),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->disabled()
                                    ->dehydrated(),

                                RichEditor::make('description')
                                    ->label('Mô tả')
                                    ->maxLength(65535)
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'undo',
                                        'redo',
                                    ]),
                            ])
                            ->columnSpan(1),

                        Section::make('Giá và Kho')
                            ->components([
                                TextInput::make('price')
                                    ->label('Giá (VNĐ)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('₫')
                                    ->minValue(0)
                                    ->step(1000)
                                    ->rules(['min:0']),

                                TextInput::make('stock_quantity')
                                    ->label('Số lượng tồn kho')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->step(1)
                                    ->rules(['integer', 'min:0']),

                                TextInput::make('warranty_period')
                                    ->label('Thời gian bảo hành (tháng)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(1)
                                    ->suffix('tháng')
                                    ->helperText('Nhập số tháng bảo hành cho sản phẩm')
                                    ->rules(['integer', 'min:0', 'nullable']),

                                Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'draft' => 'Nháp',
                                        'published' => 'Đã xuất bản',
                                        'out_of_stock' => 'Hết hàng',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->native(false),

                                FileUpload::make('image_path')
                                    ->label('Ảnh đại diện')
                                    ->image()
                                    ->directory('products')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }
}

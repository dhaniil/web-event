<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Get;
use Closure;


class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static array $kategoriOptions = [
        'KTYME Islam' => 'KTYME Islam',
        'KTYME Kristiani' => 'KTYME Kristiani',
        'KBBP' => 'KBBP',
        'KBPL' => 'KBPL',
        'BPPK' => 'BPPK',
        'KK' => 'KK',
        'PAKS' => 'PAKS',
        'KJDK' => 'KJDK',
        'PPBN' => 'PPBN',
        'HUMTIK' => 'HUMTIK',
        '-' => '-'
    ];

    /**
     * @throws \Exception
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Section::make('Detail Event')
                            ->description('Informasi dasar event')
                            ->icon('heroicon-o-information-circle')
                            ->collapsible()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Event')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->maxLength(100),

                                        Select::make('kategori')
                                            ->label('Kategori')
                                            ->options(static::$kategoriOptions)
                                            ->searchable()
                                            ->required(),

                                        DatePicker::make('tanggal_mulai')
                                            ->label('Tanggal Mulai')
                                            ->required()
                                            ->default(now()),

                                        TimePicker::make('waktu_mulai')
                                            ->label('Jam Mulai')
                                            ->required()
                                            ->default('08:00'),

                                        DatePicker::make('tanggal_selesai')
                                            ->label('Tanggal Selesai')
                                            ->required()
                                            ->default(now())
                                            ->afterOrEqual('tanggal_mulai')
                                            ->minDate(fn (Get $get) => $get('tanggal_mulai')),

                                        TimePicker::make('waktu_selesai')
                                            ->label('Jam Selesai')
                                            ->required()
                                            ->default('17:00')
                                            ->after('waktu_mulai')
                                            ->rules([
                                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                                    $tanggalMulai = $get('tanggal_mulai');
                                                    $tanggalSelesai = $get('tanggal_selesai');
                                                    $waktuMulai = $get('waktu_mulai');
                                                    
                                                    if ($tanggalMulai === $tanggalSelesai && $value <= $waktuMulai) {
                                                        $fail('Jam selesai harus setelah jam mulai jika di hari yang sama');
                                                    }
                                                },
                                            ]),
                                    ]),
                            ]),

                        Section::make('Lokasi & Status')
                            ->description('Informasi lokasi dan status event')
                            ->icon('heroicon-o-map-pin')
                            ->collapsible()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('tempat')
                                            ->label('Lokasi')
                                            ->required(),

                                        Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'selesai' => 'Selesai',
                                                'sedang berlangsung' => 'Sedang Berlangsung',
                                                'dibatalkan' => 'Dibatalkan',
                                                'ditunda' => 'Ditunda',
                                                'belum mulai' => 'Belum Mulai',
                                            ])
                                            ->required()
                                            ->searchable(),

                                        TextInput::make('penyelenggara')
                                            ->label('Penyelenggara')
                                            ->required(),

                                        // TagsInput::make('tags')
                                        //     ->label('Tags')
                                        //     ->separator(','),
                                    ]),
                            ]),

                        Section::make('Konten')
                            ->description('Deskripsi dan media event')
                            ->icon('heroicon-o-photo')
                            ->collapsible()
                            ->schema([
                                RichEditor::make('description')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                    ]),

                                    FileUpload::make('image')
                                    ->label('Gambar Event')
                                    ->required()
                                    ->image()
                                    ->maxSize(5120)
                                    ->directory('events')
                                    ->preserveFilenames()
                                    ->imageEditor()
                                    ->helperText('Gambar ini akan ditampilkan di dashboard dan kartu event'),

                                    FileUpload::make('banner')
                                    ->label('Banner Event')
                                    ->image()
                                    ->directory('event-banners')
                                    ->preserveFilenames()
                                    ->maxSize(5120)
                                    ->helperText('Banner ini akan ditampilkan di halaman detail event, ukuran yang direkomendasikan: 1200x400px'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular()
                    ->size(40),
                
                TextColumn::make('name')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->tempat),

                TextColumn::make('tanggal_mulai')
                    ->label('Waktu')
                    ->sortable()
                    ->formatStateUsing(fn ($record) => 
                        date('d/m/Y', strtotime($record->tanggal_mulai)) . ' ' . $record->waktu_mulai
                    ),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'selesai' => 'success',
                        'sedang berlangsung' => 'primary',
                        'dibatalkan' => 'danger',
                        'ditunda' => 'warning',
                        'belum mulai' => 'info',
                    }),

                TextColumn::make('kategori')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visit_count')
                    ->label('Pengunjung')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'selesai' => 'Selesai',
                        'sedang berlangsung' => 'Sedang Berlangsung',
                        'dibatalkan' => 'Dibatalkan',
                        'ditunda' => 'Ditunda',
                        'belum mulai' => 'Belum Mulai',
                    ]),
                
                SelectFilter::make('kategori')
                    ->options(static::$kategoriOptions),

                Filter::make('popular')
                    ->query(fn ($query) => $query->where('visit_count', '>', 100))
                    ->label('Event Populer'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}

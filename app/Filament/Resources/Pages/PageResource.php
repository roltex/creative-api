<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocument;

    protected static ?string $navigationLabel = 'გვერდები';

    protected static ?string $modelLabel = 'გვერდი';

    protected static ?string $pluralModelLabel = 'გვერდები';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('template')
                    ->options([
                        'default' => 'Default Page',
                        'mission' => 'Mission & Goals',
                        'reports' => 'Reports & Strategy',
                        'acts' => 'Acts & Regulations',
                        'contact' => 'Contact Page',
                        'about' => 'About Page',
                    ])
                    ->required()
                    ->default('default')
                    ->reactive()
                    ->columnSpanFull(),
                
                Tabs::make('Basic Information')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('title.ka')
                                    ->label('Page Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle.ka')
                                    ->label('Page Subtitle')
                                    ->maxLength(500)
                                    ->helperText('Optional subtitle that appears under the page title'),
                                
                                Forms\Components\Textarea::make('content.ka')
                                    ->label('Main Content')
                                    ->rows(5)
                                    ->visible(fn ($get) => in_array($get('template'), ['default', 'about', 'contact'])),
                                
                                Forms\Components\TextInput::make('meta_title.ka')
                                    ->label('SEO Title')
                                    ->maxLength(60),
                                
                                Forms\Components\Textarea::make('meta_description.ka')
                                    ->label('SEO Description')
                                    ->maxLength(160)
                                    ->rows(3),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Page Title')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('subtitle.en')
                                    ->label('Page Subtitle')
                                    ->maxLength(500)
                                    ->helperText('Optional subtitle that appears under the page title'),
                                
                                Forms\Components\Textarea::make('content.en')
                                    ->label('Main Content')
                                    ->rows(5)
                                    ->visible(fn ($get) => in_array($get('template'), ['default', 'about', 'contact'])),
                                
                                Forms\Components\TextInput::make('meta_title.en')
                                    ->label('SEO Title')
                                    ->maxLength(60),
                                
                                Forms\Components\Textarea::make('meta_description.en')
                                    ->label('SEO Description')
                                    ->maxLength(160)
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                // Mission Template Fields
                Tabs::make('Mission Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('mission_title.ka')
                                    ->label('Mission Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('mission_content.ka')
                                    ->label('Mission Text (First Paragraph)')
                                    ->rows(4),
                                
                                Forms\Components\Textarea::make('mission_content_2.ka')
                                    ->label('Mission Text (Second Paragraph)')
                                    ->rows(4),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('mission_title.en')
                                    ->label('Mission Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('mission_content.en')
                                    ->label('Mission Text (First Paragraph)')
                                    ->rows(4),
                                
                                Forms\Components\Textarea::make('mission_content_2.en')
                                    ->label('Mission Text (Second Paragraph)')
                                    ->rows(4),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Goals Template Fields
                Tabs::make('Goals Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('goals_title.ka')
                                    ->label('Goals Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('goals_content.ka')
                                    ->label('Goals Introduction Text')
                                    ->rows(3),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('goals_title.en')
                                    ->label('Goals Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('goals_content.en')
                                    ->label('Goals Introduction Text')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Goals List (Both Languages)
                Forms\Components\Repeater::make('goals_list')
                    ->label('Goals List')
                    ->schema([
                        Forms\Components\Textarea::make('ka')
                            ->label('Goal (Georgian)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Textarea::make('en')
                            ->label('Goal (English)')
                            ->required()
                            ->rows(2),
                    ])
                    ->columns(2)
                    ->maxItems(8)
                    ->addActionLabel('Add Goal')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Values Title
                Tabs::make('Values Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('values_title.ka')
                                    ->label('Values Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('values_title.en')
                                    ->label('Values Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Values List (Both Languages)
                Forms\Components\Repeater::make('values_list')
                    ->label('Values')
                    ->schema([
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-heart'),
                    ])
                    ->columns(2)
                    ->maxItems(6)
                    ->addActionLabel('Add Value')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Stats Title
                Tabs::make('Statistics Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('stats_title.ka')
                                    ->label('Statistics Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('stats_title.en')
                                    ->label('Statistics Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Statistics List (Both Languages)
                Forms\Components\Repeater::make('stats_list')
                    ->label('Statistics')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Number')
                            ->required()
                            ->placeholder('1000+'),
                        
                        Forms\Components\TextInput::make('label_ka')
                            ->label('Label (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('label_en')
                            ->label('Label (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-chart-bar'),
                    ])
                    ->columns(2)
                    ->maxItems(6)
                    ->addActionLabel('Add Statistic')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'mission'),
                
                // Reports Template Fields
                // Annual Reports Section
                Tabs::make('Annual Reports Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('annual_reports_title.ka')
                                    ->label('Annual Reports Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('annual_reports_title.en')
                                    ->label('Annual Reports Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                Forms\Components\Repeater::make('annual_reports_list')
                    ->label('Annual Reports')
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Year')
                            ->required()
                            ->numeric()
                            ->placeholder('2024'),
                        
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\FileUpload::make('file')
                            ->label('Report File')
                            ->disk('public')
                            ->directory('reports/annual')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-document-text')
                            ->default('heroicon-o-document-text'),
                    ])
                    ->columns(2)
                    ->maxItems(10)
                    ->addActionLabel('Add Report')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                // Strategic Plans Section
                Tabs::make('Strategic Plans Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('strategic_plans_title.ka')
                                    ->label('Strategic Plans Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('strategic_plans_title.en')
                                    ->label('Strategic Plans Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                Forms\Components\Repeater::make('strategic_plans_list')
                    ->label('Strategic Plans')
                    ->schema([
                        Forms\Components\TextInput::make('period')
                            ->label('Period')
                            ->required()
                            ->placeholder('2025-2027'),
                        
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\FileUpload::make('file')
                            ->label('Strategy Document')
                            ->disk('public')
                            ->directory('reports/strategic')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240),
                        
                        Forms\Components\Select::make('style')
                            ->label('Card Style')
                            ->options([
                                'primary' => 'Primary (Teal)',
                                'secondary' => 'Secondary (Blue)',
                            ])
                            ->default('primary'),
                    ])
                    ->columns(2)
                    ->maxItems(5)
                    ->addActionLabel('Add Strategic Plan')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                // Financial Reports Section
                Tabs::make('Financial Reports Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('financial_reports_title.ka')
                                    ->label('Financial Reports Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('financial_reports_title.en')
                                    ->label('Financial Reports Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                Forms\Components\Repeater::make('financial_reports_list')
                    ->label('Financial Reports')
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Year')
                            ->required()
                            ->numeric()
                            ->placeholder('2024'),
                        
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(2),
                        
                        Forms\Components\FileUpload::make('file')
                            ->label('Financial Report File')
                            ->disk('public')
                            ->directory('reports/financial')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240),
                    ])
                    ->columns(2)
                    ->maxItems(10)
                    ->addActionLabel('Add Financial Report')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                // Key Achievements for Reports (reuse stats structure)
                Tabs::make('Key Achievements Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('achievements_title.ka')
                                    ->label('Achievements Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('achievements_title.en')
                                    ->label('Achievements Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                Forms\Components\Repeater::make('achievements_list')
                    ->label('Key Achievements')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Number/Statistic')
                            ->required()
                            ->placeholder('1000+'),
                        
                        Forms\Components\TextInput::make('label_ka')
                            ->label('Label (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('label_en')
                            ->label('Label (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-chart-bar')
                            ->default('heroicon-o-chart-bar'),
                    ])
                    ->columns(2)
                    ->maxItems(6)
                    ->addActionLabel('Add Achievement')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'reports'),
                
                // Acts Template Fields
                // Legal Acts Section
                Tabs::make('Legal Acts Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('legal_acts_title.ka')
                                    ->label('Legal Acts Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('legal_acts_title.en')
                                    ->label('Legal Acts Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                Forms\Components\Repeater::make('legal_acts_list')
                    ->label('Legal Acts')
                    ->schema([
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Act Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Act Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(3),
                        
                        Forms\Components\FileUpload::make('file')
                            ->label('Legal Document')
                            ->disk('public')
                            ->directory('legal/acts')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(20480), // 20MB for legal docs
                        
                        Forms\Components\Select::make('style')
                            ->label('Card Style')
                            ->options([
                                'primary' => 'Primary (Teal)',
                                'secondary' => 'Secondary (Blue)',
                            ])
                            ->default('primary')
                            ->required(),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-scale')
                            ->default('heroicon-o-scale'),
                    ])
                    ->columns(2)
                    ->maxItems(10)
                    ->addActionLabel('Add Legal Act')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                // Regulations Section
                Tabs::make('Regulations Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('regulations_title.ka')
                                    ->label('Regulations Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('regulations_title.en')
                                    ->label('Regulations Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                Forms\Components\Repeater::make('regulations_list')
                    ->label('Regulations')
                    ->schema([
                        Forms\Components\TextInput::make('title_ka')
                            ->label('Regulation Title (Georgian)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('title_en')
                            ->label('Regulation Title (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_ka')
                            ->label('Description (Georgian)')
                            ->required()
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(3),
                        
                        Forms\Components\FileUpload::make('file')
                            ->label('Regulation Document')
                            ->disk('public')
                            ->directory('legal/regulations')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(20480), // 20MB
                        
                        Forms\Components\Select::make('style')
                            ->label('Card Style')
                            ->options([
                                'primary' => 'Primary (Teal)',
                                'secondary' => 'Secondary (Blue)',
                            ])
                            ->default('primary')
                            ->required(),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('heroicon-o-document')
                            ->default('heroicon-o-document'),
                    ])
                    ->columns(2)
                    ->maxItems(20)
                    ->addActionLabel('Add Regulation')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                // Additional Information Section
                Tabs::make('Additional Information Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('additional_info_title.ka')
                                    ->label('Additional Info Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('additional_info_content.ka')
                                    ->label('Additional Info Content')
                                    ->rows(3),
                                
                                Forms\Components\TextInput::make('additional_info_button_text.ka')
                                    ->label('Button Text')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('additional_info_title.en')
                                    ->label('Additional Info Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('additional_info_content.en')
                                    ->label('Additional Info Content')
                                    ->rows(3),
                                
                                Forms\Components\TextInput::make('additional_info_button_text.en')
                                    ->label('Button Text')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                Forms\Components\TextInput::make('additional_info_button_url')
                    ->label('Button URL')
                    ->url()
                    ->placeholder('/contact')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'acts'),
                
                // Contact Template Fields
                // Contact Form Section
                Tabs::make('Contact Form Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('contact_form_title.ka')
                                    ->label('Contact Form Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('contact_form_title.en')
                                    ->label('Contact Form Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                // Contact Information Section
                Tabs::make('Contact Information')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('contact_info_title.ka')
                                    ->label('Contact Info Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('contact_address.ka')
                                    ->label('Address (Georgian)')
                                    ->rows(2)
                                    ->placeholder('თბილისი, რუსთაველის გამზირი 42'),
                                
                                Forms\Components\TextInput::make('office_hours_title.ka')
                                    ->label('Office Hours Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('office_hours_text.ka')
                                    ->label('Office Hours Text')
                                    ->rows(2)
                                    ->placeholder('ორშაბათი - პარასკევი: 10:00 - 18:00'),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('contact_info_title.en')
                                    ->label('Contact Info Section Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('contact_address.en')
                                    ->label('Address (English)')
                                    ->rows(2)
                                    ->placeholder('42 Rustaveli Avenue, Tbilisi, Georgia'),
                                
                                Forms\Components\TextInput::make('office_hours_title.en')
                                    ->label('Office Hours Title')
                                    ->maxLength(255),
                                
                                Forms\Components\Textarea::make('office_hours_text.en')
                                    ->label('Office Hours Text')
                                    ->rows(2)
                                    ->placeholder('Monday - Friday: 10:00 - 18:00'),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                // Contact Details
                Forms\Components\TextInput::make('contact_phone')
                    ->label('Phone Number')
                    ->tel()
                    ->placeholder('+995 32 2 123 456')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\TextInput::make('contact_email')
                    ->label('Email Address')
                    ->email()
                    ->placeholder('info@creative-georgia.ge')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                // Social Media Section
                Tabs::make('Social Media Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('social_media_title.ka')
                                    ->label('Social Media Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('social_media_title.en')
                                    ->label('Social Media Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\Repeater::make('social_media_links')
                    ->label('Social Media Links')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'linkedin' => 'LinkedIn',
                                'twitter' => 'Twitter',
                                'youtube' => 'YouTube',
                                'tiktok' => 'TikTok',
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('url')
                            ->label('Profile URL')
                            ->url()
                            ->required()
                            ->placeholder('https://facebook.com/creativegeorgia'),
                        
                        Forms\Components\TextInput::make('icon_class')
                            ->label('Icon Class')
                            ->placeholder('lucide-facebook')
                            ->helperText('Icon class for display'),
                    ])
                    ->columns(3)
                    ->maxItems(10)
                    ->addActionLabel('Add Social Link')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                // Map Section
                Tabs::make('Map Section')
                    ->tabs([
                        Tabs\Tab::make('Georgian')
                            ->schema([
                                Forms\Components\TextInput::make('map_title.ka')
                                    ->label('Map Section Title')
                                    ->maxLength(255),
                            ]),
                        
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('map_title.en')
                                    ->label('Map Section Title')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\Textarea::make('map_embed_url')
                    ->label('Map Embed URL')
                    ->rows(3)
                    ->placeholder('https://maps.google.com/maps?q=...')
                    ->helperText('Google Maps embed iframe src URL')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\TextInput::make('map_latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->placeholder('41.6938')
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\TextInput::make('map_longitude')
                    ->label('Longitude')
                    ->numeric()
                    ->placeholder('44.8015')
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                Forms\Components\TextInput::make('map_zoom')
                    ->label('Map Zoom Level')
                    ->numeric()
                    ->default(16)
                    ->minValue(1)
                    ->maxValue(20)
                    ->visible(fn ($get) => $get('template') === 'contact'),
                
                // Settings
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ->default('published'),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Order for sorting pages (lower numbers first)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['ka'] ?? $state['en'] ?? '') : $state)
                    ->searchable()
                    ->limit(40)
                    ->description(fn ($record) => 
                        is_array($record->subtitle) 
                            ? ($record->subtitle['ka'] ?? $record->subtitle['en'] ?? '') 
                            : ($record->subtitle ?? '')
                    ),
                Tables\Columns\TextColumn::make('template')
                    ->badge()
                    ->colors([
                        'primary' => 'mission',
                        'success' => 'reports',
                        'danger' => 'acts',
                        'warning' => 'contact',
                        'info' => 'about',
                        'gray' => 'default',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'secondary' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('template')
                    ->options([
                        'default' => 'Default',
                        'mission' => 'Mission & Goals',
                        'reports' => 'Reports & Strategy',
                        'acts' => 'Acts & Regulations',
                        'contact' => 'Contact Page',
                        'about' => 'About',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
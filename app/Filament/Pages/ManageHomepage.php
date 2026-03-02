<?php

namespace App\Filament\Pages;

use BackedEnum;
use App\Models\HomepageSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class ManageHomepage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
    protected static ?string $navigationLabel = 'მთავარი გვერდი';
    protected static ?string $title = 'მთავარი გვერდის მართვა';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.manage-homepage';

    public static function getNavigationGroup(): ?string
    {
        return 'საიტის პარამეტრები';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = HomepageSetting::instance();

        $this->form->fill([
            'show_hero_banner' => $settings->show_hero_banner,
            'show_cta' => $settings->show_cta,
            'show_competitions' => $settings->show_competitions,
            'show_news' => $settings->show_news,
            'show_events' => $settings->show_events,
            'show_success_stories' => $settings->show_success_stories,

            'competitions_title_ka' => $settings->getTranslation('competitions_title', 'ka'),
            'competitions_title_en' => $settings->getTranslation('competitions_title', 'en'),
            'news_title_ka' => $settings->getTranslation('news_title', 'ka'),
            'news_title_en' => $settings->getTranslation('news_title', 'en'),
            'events_title_ka' => $settings->getTranslation('events_title', 'ka'),
            'events_title_en' => $settings->getTranslation('events_title', 'en'),
            'success_stories_title_ka' => $settings->getTranslation('success_stories_title', 'ka'),
            'success_stories_title_en' => $settings->getTranslation('success_stories_title', 'en'),

            'cta_title_ka' => $settings->getTranslation('cta_title', 'ka'),
            'cta_title_en' => $settings->getTranslation('cta_title', 'en'),
            'cta_subtitle_ka' => $settings->getTranslation('cta_subtitle', 'ka'),
            'cta_subtitle_en' => $settings->getTranslation('cta_subtitle', 'en'),
            'cta_button_text_ka' => $settings->getTranslation('cta_button_text', 'ka'),
            'cta_button_text_en' => $settings->getTranslation('cta_button_text', 'en'),
            'cta_button_url' => $settings->cta_button_url,
            'cta_stats' => $settings->cta_stats ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Homepage Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('სექციების ხილვადობა')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Forms\Components\Section::make('აირჩიეთ რომელი სექციები გამოჩნდეს მთავარ გვერდზე')
                                    ->schema([
                                        Forms\Components\Toggle::make('show_hero_banner')
                                            ->label('ჰერო ბანერი')
                                            ->helperText('მთავარი სლაიდერი/ბანერი')
                                            ->default(true),
                                        Forms\Components\Toggle::make('show_cta')
                                            ->label('CTA სექცია')
                                            ->helperText('მოქმედებისკენ მოწოდების სექცია სტატისტიკით')
                                            ->default(true),
                                        Forms\Components\Toggle::make('show_competitions')
                                            ->label('მიმდინარე კონკურსები')
                                            ->helperText('კონკურსების სლაიდერი')
                                            ->default(true),
                                        Forms\Components\Toggle::make('show_news')
                                            ->label('უახლესი სიახლეები')
                                            ->helperText('სიახლეების სლაიდერი')
                                            ->default(true),
                                        Forms\Components\Toggle::make('show_events')
                                            ->label('მოახლოებული ღონისძიებები')
                                            ->helperText('ღონისძიებების კალენდარი')
                                            ->default(true),
                                        Forms\Components\Toggle::make('show_success_stories')
                                            ->label('წარმატებული ისტორიები')
                                            ->helperText('წარმატებული ისტორიების სლაიდერი')
                                            ->default(false),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('სექციების სათაურები')
                            ->icon('heroicon-o-pencil')
                            ->schema([
                                Forms\Components\Section::make('კონკურსების სექცია')
                                    ->schema([
                                        Forms\Components\TextInput::make('competitions_title_ka')
                                            ->label('სათაური (ქართულად)')
                                            ->required(),
                                        Forms\Components\TextInput::make('competitions_title_en')
                                            ->label('სათაური (ინგლისურად)')
                                            ->required(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('სიახლეების სექცია')
                                    ->schema([
                                        Forms\Components\TextInput::make('news_title_ka')
                                            ->label('სათაური (ქართულად)')
                                            ->required(),
                                        Forms\Components\TextInput::make('news_title_en')
                                            ->label('სათაური (ინგლისურად)')
                                            ->required(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('ღონისძიებების სექცია')
                                    ->schema([
                                        Forms\Components\TextInput::make('events_title_ka')
                                            ->label('სათაური (ქართულად)')
                                            ->required(),
                                        Forms\Components\TextInput::make('events_title_en')
                                            ->label('სათაური (ინგლისურად)')
                                            ->required(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('წარმატებული ისტორიების სექცია')
                                    ->schema([
                                        Forms\Components\TextInput::make('success_stories_title_ka')
                                            ->label('სათაური (ქართულად)')
                                            ->required(),
                                        Forms\Components\TextInput::make('success_stories_title_en')
                                            ->label('სათაური (ინგლისურად)')
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('CTA სექცია')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Forms\Components\Section::make('ტექსტი')
                                    ->schema([
                                        Forms\Components\TextInput::make('cta_title_ka')
                                            ->label('სათაური (ქართულად)')
                                            ->required(),
                                        Forms\Components\TextInput::make('cta_title_en')
                                            ->label('სათაური (ინგლისურად)')
                                            ->required(),
                                        Forms\Components\Textarea::make('cta_subtitle_ka')
                                            ->label('ქვესათაური (ქართულად)')
                                            ->rows(3),
                                        Forms\Components\Textarea::make('cta_subtitle_en')
                                            ->label('ქვესათაური (ინგლისურად)')
                                            ->rows(3),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('ღილაკი')
                                    ->schema([
                                        Forms\Components\TextInput::make('cta_button_text_ka')
                                            ->label('ღილაკის ტექსტი (ქართულად)'),
                                        Forms\Components\TextInput::make('cta_button_text_en')
                                            ->label('ღილაკის ტექსტი (ინგლისურად)'),
                                        Forms\Components\TextInput::make('cta_button_url')
                                            ->label('ღილაკის URL')
                                            ->placeholder('/application/step-1')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('სტატისტიკა')
                                    ->schema([
                                        Forms\Components\Repeater::make('cta_stats')
                                            ->label('სტატისტიკის ელემენტები')
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->label('რიცხვი')
                                                    ->placeholder('1')
                                                    ->required(),
                                                Forms\Components\TextInput::make('suffix')
                                                    ->label('სუფიქსი')
                                                    ->placeholder('K+, M+, +')
                                                    ->required(),
                                                Forms\Components\TextInput::make('label.ka')
                                                    ->label('ლეიბლი (ქართულად)')
                                                    ->required(),
                                                Forms\Components\TextInput::make('label.en')
                                                    ->label('ლეიბლი (ინგლისურად)')
                                                    ->required(),
                                            ])
                                            ->columns(4)
                                            ->defaultItems(3)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => ($state['value'] ?? '') . ($state['suffix'] ?? '') . ' - ' . ($state['label']['ka'] ?? '')),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = HomepageSetting::instance();

        $settings->update([
            'show_hero_banner' => $data['show_hero_banner'] ?? true,
            'show_cta' => $data['show_cta'] ?? true,
            'show_competitions' => $data['show_competitions'] ?? true,
            'show_news' => $data['show_news'] ?? true,
            'show_events' => $data['show_events'] ?? true,
            'show_success_stories' => $data['show_success_stories'] ?? false,

            'competitions_title' => ['ka' => $data['competitions_title_ka'] ?? '', 'en' => $data['competitions_title_en'] ?? ''],
            'news_title' => ['ka' => $data['news_title_ka'] ?? '', 'en' => $data['news_title_en'] ?? ''],
            'events_title' => ['ka' => $data['events_title_ka'] ?? '', 'en' => $data['events_title_en'] ?? ''],
            'success_stories_title' => ['ka' => $data['success_stories_title_ka'] ?? '', 'en' => $data['success_stories_title_en'] ?? ''],

            'cta_title' => ['ka' => $data['cta_title_ka'] ?? '', 'en' => $data['cta_title_en'] ?? ''],
            'cta_subtitle' => ['ka' => $data['cta_subtitle_ka'] ?? '', 'en' => $data['cta_subtitle_en'] ?? ''],
            'cta_button_text' => ['ka' => $data['cta_button_text_ka'] ?? '', 'en' => $data['cta_button_text_en'] ?? ''],
            'cta_button_url' => $data['cta_button_url'] ?? '/application/step-1',
            'cta_stats' => $data['cta_stats'] ?? [],
        ]);

        Notification::make()
            ->title('შენახულია!')
            ->body('მთავარი გვერდის პარამეტრები წარმატებით განახლდა.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('შენახვა')
                ->submit('save'),
        ];
    }
}

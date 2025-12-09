<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('status')
                    ->label('სტატუსი')
                    ->options([
                        'draft' => 'შავი',
                        'submitted' => 'გაგზავნილი',
                        'received' => 'მიღებული',
                        'reviewing' => 'განხილვის პროცესში',
                        'approved' => 'დამტკიცებული',
                        'rejected' => 'უარყოფილი',
                    ])
                    ->required()
                    ->columnSpanFull(),

                Tabs::make('განაცხადის დეტალები')
                    ->tabs([
                        Tabs\Tab::make('ნაბიჯი 1: პირველადი ინფორმაცია')
                            ->schema([
                                Forms\Components\Select::make('form_data.applicantType')
                                    ->label('განმცხადებლის ტიპი')
                                    ->options([
                                        'legal_entity' => 'იურიდიული პირი',
                                        'individual' => 'ფიზიკური პირი',
                                    ])
                                    ->disabled()
                                    ->columnSpanFull(),

                                // Legal Entity Fields
                                Forms\Components\TextInput::make('form_data.orgName')
                                    ->label('ორგანიზაციის დასახელება')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('form_data.orgIdCode')
                                    ->label('საიდენტიფიკაციო კოდი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity'),
                                Forms\Components\TextInput::make('form_data.orgHead')
                                    ->label('ხელმძღვანელი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity'),
                                Forms\Components\Textarea::make('form_data.orgAddress')
                                    ->label('მისამართი')
                                    ->rows(2)
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('form_data.orgPhone')
                                    ->label('ტელეფონი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity'),
                                Forms\Components\TextInput::make('form_data.orgEmail')
                                    ->label('ელფოსტა')
                                    ->email()
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'legal_entity'),

                                // Individual Fields
                                Forms\Components\TextInput::make('form_data.personFullName')
                                    ->label('სრული სახელი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'individual')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('form_data.personIdNumber')
                                    ->label('პირადი ნომერი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'individual'),
                                Forms\Components\TextInput::make('form_data.personPhone')
                                    ->label('ტელეფონი')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'individual'),
                                Forms\Components\TextInput::make('form_data.personEmail')
                                    ->label('ელფოსტა')
                                    ->email()
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicantType') === 'individual'),

                                // Contact Person
                                Forms\Components\TextInput::make('form_data.contactFullName')
                                    ->label('საკონტაქტო პირის სრული სახელი')
                                    ->disabled()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('form_data.contactPersonalId')
                                    ->label('პირადი ნომერი')
                                    ->disabled(),
                                Forms\Components\TextInput::make('form_data.contactPhone')
                                    ->label('ტელეფონი')
                                    ->disabled(),
                                Forms\Components\TextInput::make('form_data.contactEmail')
                                    ->label('ელფოსტა')
                                    ->email()
                                    ->disabled(),

                                // Co-financing
                                Forms\Components\Select::make('form_data.hasCofunding')
                                    ->label('კოფინანსირება')
                                    ->options([
                                        'yes' => 'კი',
                                        'no' => 'არა',
                                    ])
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('form_data.cofunders')
                                    ->label('კოფინანსორები')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('დასახელება')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('idCode')
                                            ->label('საიდენტიფიკაციო კოდი')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('head')
                                            ->label('ხელმძღვანელი')
                                            ->disabled(),
                                        Forms\Components\Textarea::make('address')
                                            ->label('მისამართი')
                                            ->rows(2)
                                            ->disabled()
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('ტელეფონი')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('ელფოსტა')
                                            ->email()
                                            ->disabled(),
                                    ])
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.hasCofunding') === 'yes')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('ნაბიჯი 2: პროექტის ინფორმაცია')
                            ->schema([
                                Forms\Components\Select::make('form_data.applicationType')
                                    ->label('განაცხადის ტიპი')
                                    ->options([
                                        'competitive' => 'კონკურსული',
                                        'non_competitive' => 'არაკონკურსული',
                                    ])
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('form_data.competitionTitle')
                                    ->label('კონკურსის დასახელება')
                                    ->disabled()
                                    ->visible(fn ($get) => $get('form_data.applicationType') === 'competitive')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('form_data.title')
                                    ->label('პროექტის დასახელება')
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('form_data.requestedAmountGel')
                                    ->label('მოთხოვნილი თანხა (₾)')
                                    ->numeric()
                                    ->prefix('₾')
                                    ->disabled(),

                                Forms\Components\DatePicker::make('form_data.startDate')
                                    ->label('დაწყების თარიღი')
                                    ->disabled(),
                                Forms\Components\DatePicker::make('form_data.endDate')
                                    ->label('დასრულების თარიღი')
                                    ->disabled(),

                                Forms\Components\Textarea::make('form_data.projectDescription')
                                    ->label('პროექტის აღწერა')
                                    ->rows(6)
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('form_data.evaluationCriteria')
                                    ->label('შეფასების კრიტერიუმები')
                                    ->rows(4)
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('form_data.experience')
                                    ->label('რელევანტური გამოცდილება')
                                    ->rows(4)
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('form_data.stages')
                                    ->label('პროექტის ეტაპები')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('ეტაპის დასახელება')
                                            ->disabled()
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('assignee')
                                            ->label('პასუხისმგებელი')
                                            ->disabled(),
                                        Forms\Components\DatePicker::make('startDate')
                                            ->label('დაწყების თარიღი')
                                            ->disabled(),
                                        Forms\Components\DatePicker::make('endDate')
                                            ->label('დასრულების თარიღი')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('location')
                                            ->label('ადგილმდებარეობა')
                                            ->disabled()
                                            ->columnSpanFull(),
                                    ])
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('ნაბიჯი 3: პროექტის ბიუჯეტი')
                            ->schema([
                                Forms\Components\TextInput::make('form_data.totalBudgetGel')
                                    ->label('მთლიანი ბიუჯეტი (₾)')
                                    ->numeric()
                                    ->prefix('₾')
                                    ->disabled(),
                                Forms\Components\TextInput::make('form_data.requestedFromCreativeGeorgia')
                                    ->label('მ.შ. სსიპ შემოქმედებითი საქართველოდან მოთხოვნილი თანხა (₾)')
                                    ->numeric()
                                    ->prefix('₾')
                                    ->disabled(),
                                Forms\Components\TextInput::make('form_data.selfFundingGel')
                                    ->label('მ.შ. თვითდაფინანსება (₾)')
                                    ->numeric()
                                    ->prefix('₾')
                                    ->disabled(),
                                Forms\Components\TextInput::make('form_data.coFundingGel')
                                    ->label('მ.შ. დაფინანსება სხვა წყაროდან (₾)')
                                    ->numeric()
                                    ->prefix('₾')
                                    ->disabled(),

                                // Expense Categories - Display formatted
                                Forms\Components\Textarea::make('form_data.expenseCategories')
                                    ->label('ხარჯების კატეგორიები')
                                    ->rows(15)
                                    ->disabled()
                                    ->formatStateUsing(function ($state) {
                                        if (!$state || !is_array($state)) {
                                            return 'ხარჯები არ არის მითითებული';
                                        }
                                        
                                        $categories = [
                                            'labor' => '1. შრომის ანაზღაურება',
                                            'honorarium' => '2. საპატიო ანაზღაურება',
                                            'transport' => '3. ტრანსპორტირება',
                                            'living' => '4. საცხოვრებელი',
                                            'rent' => '5. ქირა',
                                            'exhibition' => '6. გამოფენა',
                                            'printing' => '7. ბეჭდვა',
                                            'other' => '8. სხვა',
                                        ];
                                        
                                        $output = [];
                                        foreach ($categories as $key => $label) {
                                            $items = $state[$key] ?? [];
                                            if (!empty($items) && is_array($items)) {
                                                $output[] = "\n=== {$label} ===";
                                                foreach ($items as $index => $item) {
                                                    $total = ($item['quantity'] ?? 0) * ($item['unitPrice'] ?? 0);
                                                    $output[] = "  ნივთი " . ($index + 1) . ":";
                                                    $output[] = "    დასახელება: " . ($item['name'] ?? '-');
                                                    $output[] = "    საზომი ერთეული: " . ($item['unit'] ?? '-');
                                                    $output[] = "    რაოდენობა: " . number_format($item['quantity'] ?? 0, 2);
                                                    $output[] = "    ერთეულის ფასი: " . number_format($item['unitPrice'] ?? 0, 2) . " ₾";
                                                    $output[] = "    ჯამი: " . number_format($total, 2) . " ₾";
                                                    $output[] = "    საქართველოდან: " . number_format($item['creativeGeorgiaAmount'] ?? 0, 2) . " ₾";
                                                    $output[] = "    თვითდაფინანსება: " . number_format($item['selfFunding'] ?? 0, 2) . " ₾";
                                                    $output[] = "    სხვა წყარო: " . number_format($item['otherFunding'] ?? 0, 2) . " ₾";
                                                    $output[] = "";
                                                }
                                            }
                                        }
                                        
                                        return !empty($output) ? implode("\n", $output) : 'ხარჯები არ არის მითითებული';
                                    })
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('შეთანხმებები და ხელმოწერა')
                            ->schema([
                                Forms\Components\Checkbox::make('form_data.agreements.logoPlacement')
                                    ->label('ლოგოს განთავსების შეთანხმება')
                                    ->disabled(),
                                Forms\Components\Checkbox::make('form_data.agreements.personalData')
                                    ->label('პირადი მონაცემების დამუშავების შეთანხმება')
                                    ->disabled(),
                                Forms\Components\Checkbox::make('form_data.agreements.fundingTerms')
                                    ->label('დაფინანსების პირობების შეთანხმება')
                                    ->disabled(),
                                Forms\Components\Checkbox::make('form_data.agreements.declaration')
                                    ->label('დეკლარაცია')
                                    ->disabled(),

                                Forms\Components\TextInput::make('form_data.signature')
                                    ->label('ხელმოწერა')
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                // Admin Notes
                Forms\Components\Textarea::make('admin_notes')
                    ->label('ადმინისტრატორის შენიშვნები')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}

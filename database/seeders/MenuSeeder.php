<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📝 Seeding Menus...');
        
        // Clear existing menus and menu items
        MenuItem::truncate();
        Menu::truncate();
        
        // Create Header Menu
        $headerMenu = Menu::create([
            'name' => 'Main Menu',
            'location' => 'header',
            'description' => 'Primary navigation menu',
            'is_active' => true
        ]);

        // Create Footer Menu
        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'location' => 'footer',
            'description' => 'Footer navigation links',
            'is_active' => true
        ]);

        // Header Menu Items
        $headerItems = [
            [
                'title' => ['ka' => 'ჩვენ შესახებ', 'en' => 'About'],
                'subtitle' => ['ka' => 'ჩვენი მისია და ხედვა', 'en' => 'Our mission and vision'],
                'url' => '/about',
                'target' => '_self',
                'order' => 1,
                'is_active' => true,
                'menu_id' => $headerMenu->id,
                'children' => [
                    [
                        'title' => ['ka' => 'მისია და მიზნები', 'en' => 'Mission & Goals'],
                        'subtitle' => ['ka' => 'ჩვენი ხედვა და მისია', 'en' => 'Our vision and mission'],
                        'url' => '/about/mission',
                        'target' => '_self',
                        'order' => 1,
                        'is_active' => true,
                        'menu_id' => $headerMenu->id,
                    ],
                    [
                        'title' => ['ka' => 'ანგარიშგებები და სტრატეგია', 'en' => 'Reports & Strategy'],
                        'subtitle' => ['ka' => 'ანგარიშები და სტრატეგია', 'en' => 'Reports and strategy'],
                        'url' => '/about/reports',
                        'target' => '_self',
                        'order' => 2,
                        'is_active' => true,
                        'menu_id' => $headerMenu->id,
                    ]
                ]
            ],
            [
                'title' => ['ka' => 'კონკურსები', 'en' => 'Competitions'],
                'subtitle' => ['ka' => 'მიმდინარე და დასრულებული', 'en' => 'Current and completed'],
                'url' => '/competitions',
                'target' => '_self',
                'order' => 2,
                'is_active' => true,
                'menu_id' => $headerMenu->id,
                'children' => [
                    [
                        'title' => ['ka' => 'მიმდინარე კონკურსები', 'en' => 'Current Competitions'],
                        'subtitle' => ['ka' => 'აქტიური კონკურსები', 'en' => 'Active competitions'],
                        'url' => '/competitions/current',
                        'target' => '_self',
                        'order' => 1,
                        'is_active' => true,
                        'menu_id' => $headerMenu->id,
                    ],
                    [
                        'title' => ['ka' => 'წარმატების ისტორიები', 'en' => 'Success Stories'],
                        'subtitle' => ['ka' => 'წარმატების მაგალითები', 'en' => 'Success examples'],
                        'url' => '/competitions/success-stories',
                        'target' => '_self',
                        'order' => 2,
                        'is_active' => true,
                        'menu_id' => $headerMenu->id,
                    ]
                ]
            ],
            [
                'title' => ['ka' => 'სიახლეები', 'en' => 'News'],
                'subtitle' => ['ka' => 'უახლესი ინფორმაცია', 'en' => 'Latest information'],
                'url' => '/news',
                'target' => '_self',
                'order' => 3,
                'is_active' => true,
                'menu_id' => $headerMenu->id,
            ],
            [
                'title' => ['ka' => 'ღონისძიებები', 'en' => 'Events'],
                'subtitle' => ['ka' => 'მომავალი ღონისძიებები', 'en' => 'Upcoming events'],
                'url' => '/events',
                'target' => '_self',
                'order' => 4,
                'is_active' => true,
                'menu_id' => $headerMenu->id,
            ],
            [
                'title' => ['ka' => 'კონტაქტი', 'en' => 'Contact'],
                'subtitle' => ['ka' => 'დაგვიკავშირდით', 'en' => 'Get in touch'],
                'url' => '/contact',
                'target' => '_self',
                'order' => 5,
                'is_active' => true,
                'menu_id' => $headerMenu->id,
            ]
        ];

        // Create header menu items
        foreach ($headerItems as $itemData) {
            $children = $itemData['children'] ?? [];
            unset($itemData['children']);
            
            $parentItem = MenuItem::create($itemData);
            
            // Create children if exist
            foreach ($children as $childData) {
                $childData['parent_id'] = $parentItem->id;
                MenuItem::create($childData);
            }
        }

        // Footer Menu Items
        $footerItems = [
            [
                'title' => ['ka' => 'კონკურსები', 'en' => 'Competitions'],
                'url' => '/competitions',
                'target' => '_self',
                'order' => 1,
                'is_active' => true,
                'menu_id' => $footerMenu->id,
            ],
            [
                'title' => ['ka' => 'სიახლეები', 'en' => 'News'],
                'url' => '/news',
                'target' => '_self',
                'order' => 2,
                'is_active' => true,
                'menu_id' => $footerMenu->id,
            ],
            [
                'title' => ['ka' => 'ღონისძიებები', 'en' => 'Events'],
                'url' => '/events',
                'target' => '_self',
                'order' => 3,
                'is_active' => true,
                'menu_id' => $footerMenu->id,
            ],
            [
                'title' => ['ka' => 'კონტაქტი', 'en' => 'Contact'],
                'url' => '/contact',
                'target' => '_self',
                'order' => 4,
                'is_active' => true,
                'menu_id' => $footerMenu->id,
            ]
        ];

        foreach ($footerItems as $itemData) {
            MenuItem::create($itemData);
        }
        
        $this->command->info('✓ Seeded header and footer menus');
        $this->command->info('  - Header menu with ' . count($headerItems) . ' items');
        $this->command->info('  - Footer menu with ' . count($footerItems) . ' items');
        $this->command->info('  - Multilingual menu support');
    }
}
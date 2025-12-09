<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class AboutUsSubmenuSeeder extends Seeder
{
    public function run(): void
    {
        // Find the header menu
        $headerMenu = Menu::where('name', 'header-menu')->first();
        
        if (!$headerMenu) {
            $this->command->error('Header menu not found!');
            return;
        }

        // Find the "About" parent menu item (in header menu)
        $aboutMenuItem = MenuItem::where('menu_id', $headerMenu->id)
            ->where('url', '/about')
            ->first();

        if (!$aboutMenuItem) {
            $this->command->error('About menu item not found!');
            return;
        }

        $this->command->info("Found About menu item with ID: {$aboutMenuItem->id}");

        // Create submenu items
        $submenuItems = [
            [
                'menu_id' => $headerMenu->id,
                'parent_id' => $aboutMenuItem->id,
                'title' => [
                    'ka' => 'მისია და მიზნები',
                    'en' => 'Mission and Goals'
                ],
                'subtitle' => [
                    'ka' => 'ჩვენი ხედვა და მისია',
                    'en' => 'Our Vision and Mission'
                ],
                'url' => '/about/mission',
                'target' => '_self',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'menu_id' => $headerMenu->id,
                'parent_id' => $aboutMenuItem->id,
                'title' => [
                    'ka' => 'ანგარიშგებები და სტრატეგია',
                    'en' => 'Reports and Strategy'
                ],
                'subtitle' => [
                    'ka' => 'ანგარიშები და სტრატეგია',
                    'en' => 'Reports and Strategy'
                ],
                'url' => '/about/reports',
                'target' => '_self',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($submenuItems as $item) {
            MenuItem::create($item);
            $this->command->info("✓ Created submenu: {$item['title']['ka']}");
        }

        $this->command->info('✅ About Us submenu items created successfully!');
    }
}

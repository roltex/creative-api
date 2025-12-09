<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class CompetitionsSubmenuSeeder extends Seeder
{
    public function run(): void
    {
        // Find the header menu
        $headerMenu = Menu::where('name', 'header-menu')->first();
        
        if (!$headerMenu) {
            $this->command->error('Header menu not found!');
            return;
        }

        // Find the "Competitions" parent menu item
        $competitionsMenuItem = MenuItem::where('menu_id', $headerMenu->id)
            ->where(function($query) {
                $query->where('url', 'like', '%competition%')
                      ->orWhereRaw("json_extract(title, '$.ka') like '%კონკურს%'")
                      ->orWhereRaw("json_extract(title, '$.en') like '%Competition%'");
            })
            ->first();

        if (!$competitionsMenuItem) {
            // Show all menu items for debugging
            $this->command->warn('Competitions menu item not found! Available menu items:');
            $items = MenuItem::where('menu_id', $headerMenu->id)->get(['id', 'title', 'url']);
            foreach ($items as $item) {
                $this->command->line("ID: {$item->id}, Title: {$item->title}, URL: {$item->url}");
            }
            return;
        }

        $this->command->info("Found Competitions menu item with ID: {$competitionsMenuItem->id}");

        // Create submenu items
        $submenuItems = [
            [
                'menu_id' => $headerMenu->id,
                'parent_id' => $competitionsMenuItem->id,
                'title' => [
                    'ka' => 'მიმდინარე კონკურსები',
                    'en' => 'Current Competitions'
                ],
                'subtitle' => [
                    'ka' => 'აქტიური კონკურსები',
                    'en' => 'Active Competitions'
                ],
                'url' => '/competitions/current',
                'target' => '_self',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'menu_id' => $headerMenu->id,
                'parent_id' => $competitionsMenuItem->id,
                'title' => [
                    'ka' => 'დასრულებული კონკურსები (არქივი)',
                    'en' => 'Completed Competitions (Archive)'
                ],
                'subtitle' => [
                    'ka' => 'წარსული კონკურსები',
                    'en' => 'Past Competitions'
                ],
                'url' => '/competitions/archive',
                'target' => '_self',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'menu_id' => $headerMenu->id,
                'parent_id' => $competitionsMenuItem->id,
                'title' => [
                    'ka' => 'წარმატებული ისტორიები',
                    'en' => 'Success Stories'
                ],
                'subtitle' => [
                    'ka' => 'წარმატების მაგალითები',
                    'en' => 'Success Examples'
                ],
                'url' => '/success-stories',
                'target' => '_self',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($submenuItems as $item) {
            MenuItem::create($item);
            $this->command->info("✓ Created submenu: {$item['title']['ka']}");
        }

        $this->command->info('✅ Competitions submenu items created successfully!');
    }
}

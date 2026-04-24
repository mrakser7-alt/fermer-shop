<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === БЛОК: Создаём администратора (firstOrCreate — без дублей при повторном запуске) ===
        User::firstOrCreate(['email' => 'admin@farm.ru'], [
            'name'     => 'Администратор',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Обычный тестовый пользователь
        User::firstOrCreate(['email' => 'user@farm.ru'], [
            'name'     => 'Иван Иванов',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // === БЛОК: Создаём категории (только если их ещё нет) ===
        if (Category::count() > 0) return;

        $categories = [
            ['name' => 'Молочное',  'slug' => 'molochnoe'],
            ['name' => 'Овощи',     'slug' => 'ovoshchi'],
            ['name' => 'Мясо',      'slug' => 'myaso'],
            ['name' => 'Мёд',       'slug' => 'med'],
            ['name' => 'Зелень',    'slug' => 'zelen'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // === БЛОК: Создаём товары ===
        $products = [
            // Молочное (category_id = 1)
            ['category_id' => 1, 'name' => 'Молоко домашнее 1 л',     'slug' => 'moloko-1l',      'price' => 120, 'description' => 'Свежее молоко от коровы, без пастеризации'],
            ['category_id' => 1, 'name' => 'Творог деревенский 500 г', 'slug' => 'tvorog-500g',    'price' => 250, 'description' => 'Натуральный творог, жирность 9%'],
            ['category_id' => 1, 'name' => 'Сметана 300 г',            'slug' => 'smetana-300g',   'price' => 180, 'description' => 'Густая домашняя сметана'],

            // Овощи (category_id = 2)
            ['category_id' => 2, 'name' => 'Картофель 1 кг',          'slug' => 'kartofel-1kg',   'price' => 60,  'description' => 'Молодой картофель, сорт Синеглазка'],
            ['category_id' => 2, 'name' => 'Морковь 1 кг',            'slug' => 'morkov-1kg',     'price' => 70,  'description' => 'Сочная сладкая морковь'],
            ['category_id' => 2, 'name' => 'Капуста белокочанная 1 кг','slug' => 'kapusta-1kg',    'price' => 55,  'description' => 'Свежая капуста с огорода'],

            // Мясо (category_id = 3)
            ['category_id' => 3, 'name' => 'Курица домашняя 1 кг',    'slug' => 'kurica-1kg',     'price' => 350, 'description' => 'Домашняя курица, вскормлена зерном'],
            ['category_id' => 3, 'name' => 'Свинина шея 1 кг',        'slug' => 'svinina-1kg',    'price' => 450, 'description' => 'Свежая свинина с фермы'],

            // Мёд (category_id = 4)
            ['category_id' => 4, 'name' => 'Мёд гречишный 500 г',     'slug' => 'med-500g',       'price' => 400, 'description' => 'Тёмный душистый гречишный мёд'],

            // Зелень (category_id = 5)
            ['category_id' => 5, 'name' => 'Укроп пучок',             'slug' => 'ukrop',          'price' => 30,  'description' => 'Свежий укроп с грядки'],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge($prod, ['in_stock' => true]));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
 /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least one category exists
        $category = Category::firstOrCreate(
            ['title' => 'Web Category'], 
            ['icon' => 'uploads/category_icon/DBQwZlYt3S_1739955005.png']
        );

        // Create multiple services under this category
        Service::create([
            'category_id'     => $category->id,
            'title'           => 'Web Development',
            'description'     => 'Full-stack web development services',
            'sub_description' => 'Laravel, Vue.js, and Tailwind',
            'image'           => 'uploads/service_image/AcxgNHndws_1739955031.png',
            'status'          => 'active',
        ]);

        Service::create([
            'category_id'     => $category->id,
            'title'           => 'Graphic Design',
            'description'     => 'Professional graphic design services',
            'sub_description' => 'Logos, branding, and UI/UX',
            'image'           => 'uploads/service_image/WXn7lzTkXS_1739938582.png',
            'status'          => 'active',
        ]);

        Service::create([
            'category_id'     => $category->id,
            'title'           => 'SEO Optimization',
            'description'     => 'Improve website ranking with SEO',
            'sub_description' => 'On-page & off-page SEO',
            'image'           => 'uploads/service_image/Ry9UEm4MJp_1740041841.png',
            'status'          => 'active',
        ]);
    }
}

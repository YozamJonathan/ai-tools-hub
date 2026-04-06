<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tool;
use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Create Admin (Yozee) ──────────────────────────
        $admin = User::create([
            'name'     => 'Yozee',
            'email'    => 'admin@aitoolshub.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Create Categories ─────────────────────────────
        $categories = [
            ['name' => 'Writing',      'icon' => '✍️'],
            ['name' => 'Image',        'icon' => '🎨'],
            ['name' => 'Video',        'icon' => '🎬'],
            ['name' => 'Code',         'icon' => '💻'],
            ['name' => 'Audio',        'icon' => '🎵'],
            ['name' => 'Productivity', 'icon' => '⚡'],
            ['name' => 'Business',     'icon' => '📊'],
            ['name' => 'Research',     'icon' => '🔬'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => \Illuminate\Support\Str::slug($cat['name']),
                'icon' => $cat['icon'],
            ]);
        }

        // ── Create Tools ──────────────────────────────────
        $tools = [
            [
                'name'        => 'ChatGPT',
                'url'         => 'https://chat.openai.com',
                'description' => 'The world\'s most popular AI assistant. Great for writing, answering questions, brainstorming, and coding.',
                'category'    => 'Writing',
                'emoji'       => '🤖',
                'vote_count'  => 2841,
                'avg_rating'  => 4.8,
                'is_featured' => true,
            ],
            [
                'name'        => 'Midjourney',
                'url'         => 'https://midjourney.com',
                'description' => 'Create stunning AI-generated artwork and images with a simple text prompt inside Discord.',
                'category'    => 'Image',
                'emoji'       => '🎨',
                'vote_count'  => 1923,
                'avg_rating'  => 4.9,
                'is_featured' => true,
            ],
            [
                'name'        => 'Claude',
                'url'         => 'https://claude.ai',
                'description' => 'Anthropic\'s AI assistant — known for thoughtful, nuanced responses and excellent long-form writing.',
                'category'    => 'Writing',
                'emoji'       => '🧠',
                'vote_count'  => 1654,
                'avg_rating'  => 4.8,
                'is_featured' => false,
            ],
            [
                'name'        => 'GitHub Copilot',
                'url'         => 'https://github.com/features/copilot',
                'description' => 'AI pair programmer that suggests code completions, functions, and entire algorithms as you type.',
                'category'    => 'Code',
                'emoji'       => '👨‍💻',
                'vote_count'  => 1432,
                'avg_rating'  => 4.7,
                'is_featured' => false,
            ],
            [
                'name'        => 'Runway ML',
                'url'         => 'https://runwayml.com',
                'description' => 'Professional AI video generation and editing. Create stunning video content from text prompts.',
                'category'    => 'Video',
                'emoji'       => '🎬',
                'vote_count'  => 987,
                'avg_rating'  => 4.6,
                'is_featured' => false,
            ],
            [
                'name'        => 'ElevenLabs',
                'url'         => 'https://elevenlabs.io',
                'description' => 'Hyper-realistic AI voice synthesis and cloning. Create natural-sounding voiceovers in seconds.',
                'category'    => 'Audio',
                'emoji'       => '🎙️',
                'vote_count'  => 876,
                'avg_rating'  => 4.7,
                'is_featured' => false,
            ],
            [
                'name'        => 'Notion AI',
                'url'         => 'https://notion.so/ai',
                'description' => 'AI built into Notion. Summarize notes, draft content, and improve your writing inside your workspace.',
                'category'    => 'Productivity',
                'emoji'       => '📝',
                'vote_count'  => 765,
                'avg_rating'  => 4.5,
                'is_featured' => false,
            ],
            [
                'name'        => 'Perplexity',
                'url'         => 'https://perplexity.ai',
                'description' => 'AI-powered search engine that gives direct, cited answers instead of just links.',
                'category'    => 'Research',
                'emoji'       => '🔍',
                'vote_count'  => 1123,
                'avg_rating'  => 4.7,
                'is_featured' => false,
            ],
            [
                'name'        => 'Cursor',
                'url'         => 'https://cursor.sh',
                'description' => 'AI-first code editor built on VS Code. Chat with your codebase and generate code with full context.',
                'category'    => 'Code',
                'emoji'       => '⌨️',
                'vote_count'  => 743,
                'avg_rating'  => 4.8,
                'is_featured' => false,
            ],
            [
                'name'        => 'Suno AI',
                'url'         => 'https://suno.ai',
                'description' => 'Generate full songs with vocals, instruments, and lyrics from a text prompt in seconds.',
                'category'    => 'Audio',
                'emoji'       => '🎶',
                'vote_count'  => 654,
                'avg_rating'  => 4.5,
                'is_featured' => false,
            ],
            [
                'name'        => 'Gemini',
                'url'         => 'https://gemini.google.com',
                'description' => 'Google\'s most capable AI model. Excellent for multimodal tasks including image understanding.',
                'category'    => 'Writing',
                'emoji'       => '✨',
                'vote_count'  => 891,
                'avg_rating'  => 4.5,
                'is_featured' => false,
            ],
            [
                'name'        => 'DALL-E 3',
                'url'         => 'https://openai.com/dall-e-3',
                'description' => 'OpenAI\'s image generation model. Create detailed, photorealistic or artistic images from text.',
                'category'    => 'Image',
                'emoji'       => '🖼️',
                'vote_count'  => 892,
                'avg_rating'  => 4.6,
                'is_featured' => false,
            ],
        ];

        foreach ($tools as $toolData) {
            $category = Category::where('name', $toolData['category'])->first();
            Tool::create([
                'name'        => $toolData['name'],
                'slug'        => \Illuminate\Support\Str::slug($toolData['name']),
                'url'         => $toolData['url'],
                'description' => $toolData['description'],
                'category_id' => $category->id,
                'created_by'  => $admin->id,
                'status'      => 'approved',
                'emoji'       => $toolData['emoji'],
                'vote_count'  => $toolData['vote_count'],
                'avg_rating'  => $toolData['avg_rating'],
                'is_featured' => $toolData['is_featured'],
            ]);
        }

        // ── Create Demo User ──────────────────────────────
        $user = User::create([
            'name'     => 'Demo User',
            'email'    => 'user@aitoolshub.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // Give them a default collection
        $collection = Collection::create([
            'user_id' => $user->id,
            'name'    => 'My Favourites',
        ]);

        // Save ChatGPT and Claude to it
        $chatgpt = Tool::where('name', 'ChatGPT')->first();
        $claude  = Tool::where('name', 'Claude')->first();
        $collection->tools()->attach([$chatgpt->id, $claude->id], ['added_at' => now()]);

        echo "✅ Database seeded successfully!\n";
        echo "   Admin login: admin@aitoolshub.com / password\n";
        echo "   Demo login:  user@aitoolshub.com / password\n";
    }
}

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
            // ── NEW AI TOOLS ─────────────────────────────
[
    'name'        => 'Jasper AI',
    'url'         => 'https://jasper.ai',
    'description' => 'AI content writer for blogs, ads, and marketing copy.',
    'category'    => 'Writing',
    'emoji'       => '✍️',
    'vote_count'  => 820,
    'avg_rating'  => 4.6,
    'is_featured' => false,
],
[
    'name'        => 'Copy.ai',
    'url'         => 'https://copy.ai',
    'description' => 'Generate marketing copy, product descriptions, and social media content.',
    'category'    => 'Writing',
    'emoji'       => '📝',
    'vote_count'  => 760,
    'avg_rating'  => 4.5,
    'is_featured' => false,
],

[
    'name'        => 'Leonardo AI',
    'url'         => 'https://leonardo.ai',
    'description' => 'AI image generator for game assets and creative designs.',
    'category'    => 'Image',
    'emoji'       => '🎨',
    'vote_count'  => 690,
    'avg_rating'  => 4.7,
    'is_featured' => false,
],
[
    'name'        => 'Playground AI',
    'url'         => 'https://playgroundai.com',
    'description' => 'Create and edit images with powerful AI tools.',
    'category'    => 'Image',
    'emoji'       => '🖼️',
    'vote_count'  => 610,
    'avg_rating'  => 4.5,
    'is_featured' => false,
],

[
    'name'        => 'Pictory',
    'url'         => 'https://pictory.ai',
    'description' => 'Turn scripts and articles into engaging videos automatically.',
    'category'    => 'Video',
    'emoji'       => '🎬',
    'vote_count'  => 540,
    'avg_rating'  => 4.6,
    'is_featured' => false,
],
[
    'name'        => 'Synthesia',
    'url'         => 'https://synthesia.io',
    'description' => 'Create AI videos with realistic avatars and voiceovers.',
    'category'    => 'Video',
    'emoji'       => '📹',
    'vote_count'  => 880,
    'avg_rating'  => 4.8,
    'is_featured' => true,
],

[
    'name'        => 'Codeium',
    'url'         => 'https://codeium.com',
    'description' => 'Free AI code completion and chat for developers.',
    'category'    => 'Code',
    'emoji'       => '💻',
    'vote_count'  => 720,
    'avg_rating'  => 4.7,
    'is_featured' => false,
],
[
    'name'        => 'Tabnine',
    'url'         => 'https://tabnine.com',
    'description' => 'AI coding assistant for faster development.',
    'category'    => 'Code',
    'emoji'       => '⌨️',
    'vote_count'  => 650,
    'avg_rating'  => 4.4,
    'is_featured' => false,
],

[
    'name'        => 'Descript',
    'url'         => 'https://descript.com',
    'description' => 'Edit audio and video by editing text transcripts.',
    'category'    => 'Audio',
    'emoji'       => '🎙️',
    'vote_count'  => 700,
    'avg_rating'  => 4.6,
    'is_featured' => false,
],
[
    'name'        => 'Murf AI',
    'url'         => 'https://murf.ai',
    'description' => 'AI voice generator for professional voiceovers.',
    'category'    => 'Audio',
    'emoji'       => '🔊',
    'vote_count'  => 630,
    'avg_rating'  => 4.5,
    'is_featured' => false,
],

[
    'name'        => 'Motion',
    'url'         => 'https://usemotion.com',
    'description' => 'AI-powered task manager and calendar automation.',
    'category'    => 'Productivity',
    'emoji'       => '⚡',
    'vote_count'  => 580,
    'avg_rating'  => 4.5,
    'is_featured' => false,
],
[
    'name'        => 'Taskade AI',
    'url'         => 'https://taskade.com',
    'description' => 'Collaborative workspace with built-in AI assistant.',
    'category'    => 'Productivity',
    'emoji'       => '📋',
    'vote_count'  => 510,
    'avg_rating'  => 4.4,
    'is_featured' => false,
],

[
    'name'        => 'Tome AI',
    'url'         => 'https://tome.app',
    'description' => 'AI tool for creating presentations and storytelling.',
    'category'    => 'Business',
    'emoji'       => '📊',
    'vote_count'  => 600,
    'avg_rating'  => 4.6,
    'is_featured' => false,
],
[
    'name'        => 'Durable AI',
    'url'         => 'https://durable.co',
    'description' => 'Build a full business website instantly with AI.',
    'category'    => 'Business',
    'emoji'       => '🏢',
    'vote_count'  => 670,
    'avg_rating'  => 4.7,
    'is_featured' => true,
],

[
    'name'        => 'Elicit',
    'url'         => 'https://elicit.org',
    'description' => 'AI research assistant for finding and summarizing papers.',
    'category'    => 'Research',
    'emoji'       => '🔬',
    'vote_count'  => 720,
    'avg_rating'  => 4.7,
    'is_featured' => false,
],
[
    'name'        => 'Scite AI',
    'url'         => 'https://scite.ai',
    'description' => 'Smart citations and research insights using AI.',
    'category'    => 'Research',
    'emoji'       => '📚',
    'vote_count'  => 640,
    'avg_rating'  => 4.6,
    'is_featured' => false,
],
// ── MORE AI TOOLS (EXPAND TO 50+) ───────────────────────

// WRITING
[
    'name' => 'Writesonic',
    'url' => 'https://writesonic.com',
    'description' => 'AI writer for blogs, ads, and SEO content generation.',
    'category' => 'Writing',
    'emoji' => '✍️',
    'vote_count' => 720,
    'avg_rating' => 4.5,
    'is_featured' => false,
],
[
    'name' => 'Rytr',
    'url' => 'https://rytr.me',
    'description' => 'Affordable AI writing assistant for short and long content.',
    'category' => 'Writing',
    'emoji' => '📝',
    'vote_count' => 610,
    'avg_rating' => 4.4,
    'is_featured' => false,
],

// IMAGE
[
    'name' => 'Ideogram',
    'url' => 'https://ideogram.ai',
    'description' => 'AI image generator great for text-in-image designs.',
    'category' => 'Image',
    'emoji' => '🖼️',
    'vote_count' => 580,
    'avg_rating' => 4.6,
    'is_featured' => false,
],
[
    'name' => 'Clipdrop',
    'url' => 'https://clipdrop.co',
    'description' => 'AI tools for background removal, upscaling, and editing.',
    'category' => 'Image',
    'emoji' => '🎨',
    'vote_count' => 640,
    'avg_rating' => 4.7,
    'is_featured' => false,
],

// VIDEO
[
    'name' => 'HeyGen',
    'url' => 'https://heygen.com',
    'description' => 'Create AI avatar videos for marketing and presentations.',
    'category' => 'Video',
    'emoji' => '🎥',
    'vote_count' => 710,
    'avg_rating' => 4.7,
    'is_featured' => true,
],
[
    'name' => 'Luma AI',
    'url' => 'https://lumalabs.ai',
    'description' => 'AI tool for 3D video and realistic scene generation.',
    'category' => 'Video',
    'emoji' => '🎬',
    'vote_count' => 520,
    'avg_rating' => 4.6,
    'is_featured' => false,
],

// CODE
[
    'name' => 'Replit Ghostwriter',
    'url' => 'https://replit.com',
    'description' => 'AI coding assistant built into Replit IDE.',
    'category' => 'Code',
    'emoji' => '💻',
    'vote_count' => 680,
    'avg_rating' => 4.6,
    'is_featured' => false,
],
[
    'name' => 'Amazon CodeWhisperer',
    'url' => 'https://aws.amazon.com/codewhisperer',
    'description' => 'AI code generator by AWS for secure coding.',
    'category' => 'Code',
    'emoji' => '⌨️',
    'vote_count' => 590,
    'avg_rating' => 4.5,
    'is_featured' => false,
],

// AUDIO
[
    'name' => 'PlayHT',
    'url' => 'https://play.ht',
    'description' => 'AI text-to-speech tool with realistic voices.',
    'category' => 'Audio',
    'emoji' => '🔊',
    'vote_count' => 600,
    'avg_rating' => 4.6,
    'is_featured' => false,
],
[
    'name' => 'Voicemod AI',
    'url' => 'https://voicemod.net',
    'description' => 'AI voice changer and soundboard for creators.',
    'category' => 'Audio',
    'emoji' => '🎙️',
    'vote_count' => 550,
    'avg_rating' => 4.4,
    'is_featured' => false,
],

// PRODUCTIVITY
[
    'name' => 'Mem AI',
    'url' => 'https://mem.ai',
    'description' => 'AI-powered note-taking and knowledge management tool.',
    'category' => 'Productivity',
    'emoji' => '⚡',
    'vote_count' => 530,
    'avg_rating' => 4.5,
    'is_featured' => false,
],
[
    'name' => 'Superhuman AI',
    'url' => 'https://superhuman.com',
    'description' => 'AI email assistant to write and manage emails faster.',
    'category' => 'Productivity',
    'emoji' => '📧',
    'vote_count' => 610,
    'avg_rating' => 4.6,
    'is_featured' => false,
],

// BUSINESS
[
    'name' => 'Looka AI',
    'url' => 'https://looka.com',
    'description' => 'AI logo and brand identity generator for businesses.',
    'category' => 'Business',
    'emoji' => '🏢',
    'vote_count' => 620,
    'avg_rating' => 4.6,
    'is_featured' => false,
],
[
    'name' => 'Namecheap Logo Maker',
    'url' => 'https://namecheap.com/logo-maker',
    'description' => 'Free AI-powered logo generator for startups.',
    'category' => 'Business',
    'emoji' => '📊',
    'vote_count' => 500,
    'avg_rating' => 4.4,
    'is_featured' => false,
],

// RESEARCH
[
    'name' => 'Consensus AI',
    'url' => 'https://consensus.app',
    'description' => 'Search engine that finds answers from scientific papers.',
    'category' => 'Research',
    'emoji' => '🔬',
    'vote_count' => 700,
    'avg_rating' => 4.7,
    'is_featured' => true,
],
[
    'name' => 'Research Rabbit',
    'url' => 'https://researchrabbit.ai',
    'description' => 'Discover and organize academic papers visually.',
    'category' => 'Research',
    'emoji' => '📚',
    'vote_count' => 540,
    'avg_rating' => 4.6,
    'is_featured' => false,
],
// ── FINAL ADDITIONS (SAFE - NO DUPLICATES) ─────────────

// WRITING
[
    'name' => 'Anyword',
    'url' => 'https://anyword.com',
    'description' => 'AI copywriting tool focused on marketing performance and conversions.',
    'category' => 'Writing',
    'emoji' => '✍️',
    'vote_count' => 520,
    'avg_rating' => 4.5,
    'is_featured' => false,
],

// IMAGE
[
    'name' => 'Artbreeder',
    'url' => 'https://artbreeder.com',
    'description' => 'Create and remix AI-generated portraits and artworks.',
    'category' => 'Image',
    'emoji' => '🎨',
    'vote_count' => 580,
    'avg_rating' => 4.4,
    'is_featured' => false,
],

// VIDEO
[
    'name' => 'Animoto AI',
    'url' => 'https://animoto.com',
    'description' => 'Create marketing videos easily using AI-powered tools.',
    'category' => 'Video',
    'emoji' => '🎬',
    'vote_count' => 490,
    'avg_rating' => 4.4,
    'is_featured' => false,
],

// CODE
[
    'name' => 'CodiumAI',
    'url' => 'https://codium.ai',
    'description' => 'AI tool for generating meaningful tests for your code.',
    'category' => 'Code',
    'emoji' => '💻',
    'vote_count' => 510,
    'avg_rating' => 4.6,
    'is_featured' => false,
],

// AUDIO
[
    'name' => 'Soundraw',
    'url' => 'https://soundraw.io',
    'description' => 'AI music generator for creators and video projects.',
    'category' => 'Audio',
    'emoji' => '🎵',
    'vote_count' => 530,
    'avg_rating' => 4.5,
    'is_featured' => false,
],

// PRODUCTIVITY
[
    'name' => 'Rewind AI',
    'url' => 'https://rewind.ai',
    'description' => 'Record and search everything you have seen on your computer.',
    'category' => 'Productivity',
    'emoji' => '⚡',
    'vote_count' => 480,
    'avg_rating' => 4.5,
    'is_featured' => false,
],

// BUSINESS
[
    'name' => 'Brandmark AI',
    'url' => 'https://brandmark.io',
    'description' => 'AI-powered logo and branding generator.',
    'category' => 'Business',
    'emoji' => '📊',
    'vote_count' => 560,
    'avg_rating' => 4.6,
    'is_featured' => false,
],

// RESEARCH
[
    'name' => 'Connected Papers',
    'url' => 'https://connectedpapers.com',
    'description' => 'Visualize academic papers and research connections.',
    'category' => 'Research',
    'emoji' => '🔬',
    'vote_count' => 600,
    'avg_rating' => 4.7,
    'is_featured' => false,
],

// BONUS (TRENDING MIX)
[
    'name' => 'Gamma AI',
    'url' => 'https://gamma.app',
    'description' => 'Create presentations, docs, and websites with AI.',
    'category' => 'Business',
    'emoji' => '📈',
    'vote_count' => 670,
    'avg_rating' => 4.7,
    'is_featured' => true,
],
[
    'name' => 'Phind',
    'url' => 'https://phind.com',
    'description' => 'AI search engine specifically built for developers.',
    'category' => 'Research',
    'emoji' => '🔍',
    'vote_count' => 720,
    'avg_rating' => 4.8,
    'is_featured' => true,
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

<?php

namespace Database\Seeders;

use App\Models\AiProvider;
use App\Models\GatewayKey;
use App\Models\RoutingCombo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@omniroute.local'],
            [
                'name' => 'OmniRoute Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        // 2. Pre-configured AI Providers
        $providers = [
            [
                'slug' => 'gemini',
                'name' => 'Google Gemini',
                'base_url' => 'https://generativelanguage.googleapis.com/v1beta/openai',
                'format' => 'openai',
                'models_catalog' => ['gemini-2.5-flash', 'gemini-2.5-pro', 'gemini-2.0-flash'],
                'is_active' => true,
            ],
            [
                'slug' => 'groq',
                'name' => 'GroqCloud',
                'base_url' => 'https://api.groq.com/openai/v1',
                'format' => 'openai',
                'models_catalog' => ['llama-3.3-70b-versatile', 'llama-3.1-8b-instant', 'qwen-qwq-32b'],
                'is_active' => true,
            ],
            [
                'slug' => 'openrouter',
                'name' => 'OpenRouter',
                'base_url' => 'https://openrouter.ai/api/v1',
                'format' => 'openai',
                'models_catalog' => [
                    'qwen/qwen-2.5-coder-32b-instruct:free',
                    'meta-llama/llama-3.3-70b-instruct:free',
                    'deepseek/deepseek-r1:free',
                ],
                'is_active' => true,
            ],
            [
                'slug' => 'deepseek',
                'name' => 'DeepSeek',
                'base_url' => 'https://api.deepseek.com/v1',
                'format' => 'openai',
                'models_catalog' => ['deepseek-chat', 'deepseek-reasoner'],
                'is_active' => true,
            ],
            [
                'slug' => 'cerebras',
                'name' => 'Cerebras',
                'base_url' => 'https://api.cerebras.ai/v1',
                'format' => 'openai',
                'models_catalog' => ['llama-3.3-70b', 'llama3.1-8b'],
                'is_active' => true,
            ],
            [
                'slug' => 'mistral',
                'name' => 'Mistral AI',
                'base_url' => 'https://api.mistral.ai/v1',
                'format' => 'openai',
                'models_catalog' => ['codestral-latest', 'mistral-small-latest'],
                'is_active' => true,
            ],
            [
                'slug' => 'openai',
                'name' => 'OpenAI',
                'base_url' => 'https://api.openai.com/v1',
                'format' => 'openai',
                'models_catalog' => ['gpt-4o', 'gpt-4o-mini'],
                'is_active' => true,
            ],
            [
                'slug' => 'anthropic',
                'name' => 'Anthropic Claude',
                'base_url' => 'https://api.anthropic.com/v1',
                'format' => 'anthropic',
                'models_catalog' => ['claude-3-7-sonnet-latest', 'claude-3-5-haiku-latest'],
                'is_active' => true,
            ],
        ];

        foreach ($providers as $providerData) {
            AiProvider::updateOrCreate(
                ['slug' => $providerData['slug']],
                $providerData
            );
        }

        // 3. Default Routing Combos
        $combos = [
            [
                'name' => 'auto',
                'description' => 'Default general purpose routing combo',
                'strategy' => 'priority',
                'models' => [
                    'gemini/gemini-2.5-flash',
                    'groq/llama-3.3-70b-versatile',
                    'openrouter/meta-llama/llama-3.3-70b-instruct:free',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'auto/free',
                'description' => 'Free-tier optimized routing combo',
                'strategy' => 'priority',
                'models' => [
                    'gemini/gemini-2.5-flash',
                    'groq/llama-3.3-70b-versatile',
                    'openrouter/qwen/qwen-2.5-coder-32b-instruct:free',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'auto/coding',
                'description' => 'Coding and reasoning models routing combo',
                'strategy' => 'priority',
                'models' => [
                    'anthropic/claude-3-7-sonnet-latest',
                    'deepseek/deepseek-chat',
                    'gemini/gemini-2.5-pro',
                    'groq/llama-3.3-70b-versatile',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($combos as $comboData) {
            RoutingCombo::updateOrCreate(
                ['name' => $comboData['name']],
                $comboData
            );
        }

        // 4. Default Gateway Key
        GatewayKey::updateOrCreate(
            ['key' => 'sk-omni-master-key-1234567890abcdef'],
            [
                'name' => 'Default Master Key',
                'is_active' => true,
            ]
        );
    }
}

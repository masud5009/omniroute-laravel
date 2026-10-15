<?php

namespace Tests\Feature;

use App\Models\AiProvider;
use App\Models\ProviderAccount;
use App\Models\User;
use Tests\TestCase;

class CustomProviderDeleteTest extends TestCase
{
    public function test_custom_provider_can_be_deleted(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@omniroute.local']);

        $custom = AiProvider::create([
            'name' => 'My Custom Local LLM',
            'slug' => 'custom-llm-' . uniqid(),
            'base_url' => 'http://localhost:11434/v1',
            'format' => 'openai',
            'models_catalog' => ['llama3:8b'],
            'is_active' => true,
        ]);

        $account = ProviderAccount::create([
            'ai_provider_id' => $custom->id,
            'label' => 'Ollama Key',
            'api_key' => 'ollama-secret',
            'priority' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete("/dashboard/providers/{$custom->id}");

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('ai_providers', ['id' => $custom->id]);
        $this->assertDatabaseMissing('provider_accounts', ['id' => $account->id]);
    }

    public function test_core_system_provider_cannot_be_deleted(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@omniroute.local']);

        $coreProvider = AiProvider::where('slug', 'gemini')->first();
        $this->assertNotNull($coreProvider);

        $response = $this->actingAs($admin)->delete("/dashboard/providers/{$coreProvider->id}");

        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('ai_providers', ['id' => $coreProvider->id]);
    }
}

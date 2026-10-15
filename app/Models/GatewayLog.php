<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatewayLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'gateway_key_id',
        'requested_model',
        'routed_provider',
        'routed_model',
        'account_label',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'saved_tokens',
        'latency_ms',
        'status_code',
        'error_message',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'prompt_tokens' => 'integer',
            'completion_tokens' => 'integer',
            'total_tokens' => 'integer',
            'saved_tokens' => 'integer',
            'latency_ms' => 'integer',
            'status_code' => 'integer',
        ];
    }

    /**
     * Get the gateway key that owns the log.
     */
    public function gatewayKey(): BelongsTo
    {
        return $this->belongsTo(GatewayKey::class);
    }
}

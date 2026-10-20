<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_title',
        'version',
        'logo_path',
        'favicon_path',
    ];

    /**
     * Default branding values used for fresh installs / fallbacks.
     *
     * @return array<string, string>
     */
    public static function defaults(): array
    {
        return [
            'site_title' => 'OmniRoute',
            'version' => 'v1.0',
            'logo_path' => null,
            'favicon_path' => null,
        ];
    }

    /**
     * Get the singleton SiteSetting record or create it with defaults.
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate([], static::defaults());
    }

    /**
     * Public URL for the uploaded logo (or null when using the default icon).
     */
    public function logoUrl(): ?string
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/'.$this->logo_path);
        }

        return null;
    }

    /**
     * Public URL for the uploaded favicon (or null when using /favicon.ico).
     */
    public function faviconUrl(): ?string
    {
        if ($this->favicon_path && Storage::disk('public')->exists($this->favicon_path)) {
            return asset('storage/'.$this->favicon_path);
        }

        return null;
    }
}

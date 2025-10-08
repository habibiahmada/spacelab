<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = [
        'id', 'name', 'email', 'password_hash', 'password', 'role_id', 'last_login_at'
    ];
    protected $hidden = ['password_hash', 'password'];
    protected $casts = ['last_login_at' => 'datetime', 'email_verified_at' => 'datetime'];

    /**
     * Return the password for the authentication system.
     * The database column is `password_hash`, but other parts of the app
     * (and Laravel) expect a `password` attribute or getAuthPassword().
     */
    public function getAuthPassword(): ?string
    {
        return $this->password_hash;
    }

    /**
     * Provide a virtual `password` attribute that maps to `password_hash`.
     * We assume the value assigned is already hashed by callers (the
     * registration code calls Hash::make before creating a user).
     */
    public function getPasswordAttribute(): ?string
    {
        return $this->password_hash;
    }

    public function setPasswordAttribute(?string $value): void
    {
        // Expecting $value to already be a hashed password. Store it in password_hash.
        $this->attributes['password_hash'] = $value;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Fallback for environments where the Fortify trait may not provide
     * hasEnabledTwoFactorAuthentication. If the trait defines it, this
     * method will be ignored due to PHP method resolution order on traits.
     */
    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return ! empty($this->two_factor_secret) && ! empty($this->two_factor_confirmed_at);
    }

    /**
     * Return the uppercase initials for the user's display name.
     * Examples: "John Doe" -> "JD", "Alice" -> "A".
     */
    public function initials(): string
    {
        $name = trim($this->name ?? '');

        if ($name === '') {
            return '';
        }

        $parts = preg_split('/\s+/', $name);

        if (! is_array($parts) || count($parts) === 0) {
            return strtoupper(substr($name, 0, 1));
        }

        if (count($parts) === 1) {
            return strtoupper(substr($parts[0], 0, 1));
        }

        // Use first and last parts for initials
        $first = strtoupper(substr($parts[0], 0, 1));
        $last = strtoupper(substr($parts[count($parts) - 1], 0, 1));

        return $first . $last;
    }
}


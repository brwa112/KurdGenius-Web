<?php

namespace App\Models\Analytics;

use App\Models\System\Users\User;
use App\Models\Traits\RangeScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory, RangeScopes;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'method',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that made the visit (if authenticated).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scope to search visitors by IP or URL.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('ip_address', 'like', "%$search%")
              ->orWhere('url', 'like', "%$search%")
              ->orWhere('browser', 'like', "%$search%")
              ->orWhere('platform', 'like', "%$search%");
        });
    }

    /**
     * Scope to filter by user.
     */
    public function scopeFilterByUser($query, $userId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }

    /**
     * Scope to get unique visitors.
     */
    public function scopeUniqueIps($query)
    {
        return $query->distinct('ip_address');
    }

    /**
     * Get device type from user agent.
     */
    public static function detectDevice($userAgent)
    {
        if (preg_match('/mobile|android|iphone|ipad|ipod/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    /**
     * Get browser from user agent.
     */
    public static function detectBrowser($userAgent)
    {
        if (preg_match('/Edge/i', $userAgent)) {
            return 'Microsoft Edge';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Mozilla Firefox';
        } elseif (preg_match('/MSIE|Trident/i', $userAgent)) {
            return 'Internet Explorer';
        }
        return 'Unknown';
    }

    /**
     * Get platform from user agent.
     */
    public static function detectPlatform($userAgent)
    {
        if (preg_match('/windows/i', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'Mac OS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/android/i', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            return 'iOS';
        }
        return 'Unknown';
    }
}

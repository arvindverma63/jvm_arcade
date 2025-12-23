<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseNotification;

class Notification extends BaseNotification
{
    // You can add custom helper methods here if needed
    // Example: Helper to get a simplified icon name
    public function getIconAttribute()
    {
        return $this->data['icon'] ?? 'bell';
    }
}

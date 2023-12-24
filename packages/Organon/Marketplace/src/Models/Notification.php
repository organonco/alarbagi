<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Marketplace\Contracts\Notification as NotificationContract;

class Notification extends \Webkul\Notification\Models\Notification implements NotificationContract
{
    protected $fillable = [
        'text',
        'read',
        'user_id',
        'route',
        'route_params'
    ];

    protected $appends = ['datetime_diff', 'url'];
    protected $hidden = ['user_id', 'route', 'route_params', 'id'];


    public function getDatetimeDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getUrlAttribute()
    {
        return route($this->route, $this->route_params ? json_decode($this->route_params, true) : []);
    }

    public function markAsRead()
    {
        $this->update(['read' => true]);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
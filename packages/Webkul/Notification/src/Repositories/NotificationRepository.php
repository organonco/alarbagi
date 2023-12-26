<?php

namespace Webkul\Notification\Repositories;

use Organon\Marketplace\Models\Notification;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\Core\Eloquent\Repository;
use Webkul\Notification\Events\InternalNotificationInterface;

class NotificationRepository extends Repository
{
    use InteractsWithAuthenticatedAdmin;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return Notification::class;
    }

    /**
     * Return Filtered Notification resources
     *
     * @param array $params
     * @return array
     */
    public function getParamsData($params)
    {
        $query = $this->model->with('order');

        $query = $this->filter($query);

        if (isset($params['read']) && isset($params['limit'])) {
            $query->where('read', $params['read'])->limit($params['limit']);
        } elseif (isset($params['limit'])) {
            $query->limit($params['limit']);
        }

        $notifications = $query->latest()->paginate($params['limit'] ?? 10);


        return ['notifications' => $notifications];
    }

    /**
     * Return Notification resources
     *
     * @return array
     */
    public function getAll()
    {

        $query = $this->model->with('order');
        $query = $this->filter($query);

        $notifications = $query->latest()->paginate($params['limit'] ?? 10);
        return ['notifications' => $notifications];
    }

    public function fromInternalNotification(InternalNotificationInterface $notification, ?int $admin_id): void
    {
        $this->create([
            'admin_id' => $admin_id,
            'text' => $notification->getText(),
            'route' => $notification->getRoute(),
            'route_params' => $notification->getRouteParams()
        ]);
    }


    public function filter($query)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $query->where('admin_id', $this->getAuthenticatedAdmin()->id);
        else
            $query->whereNull('admin_id');
        return $query;
    }

    public function getCount(): int
    {
        $query = $this->where('read', 0);
        $query = $this->filter($query);
        return $query->count();
    }

    public function deleteLastNotification($route, $admin_id)
    {
        $this->where('route', $route)->where('admin_id', $admin_id)->latest()->first()->delete();
    }
}

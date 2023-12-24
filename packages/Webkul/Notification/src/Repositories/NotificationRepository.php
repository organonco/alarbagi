<?php

namespace Webkul\Notification\Repositories;

use Organon\Marketplace\Models\Notification;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\Core\Eloquent\Repository;

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
     * @param  array  $params
     * @return array
     */
    public function getParamsData($params)
    {
        $query = $this->model->with('order');

        if($this->getAuthenticatedAdmin()->isSeller())
            $query->where('admin_id', $this->getAuthenticatedAdmin()->id);
        else
            $query->whereNull('admin_id');

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

        if($this->getAuthenticatedAdmin()->isSeller())
            $query->where('admin_id', $this->getAuthenticatedAdmin()->id);
        else
            $query->whereNull('admin_id');

        $notifications = $query->latest()->paginate($params['limit'] ?? 10);
        return ['notifications' => $notifications];
    }
}

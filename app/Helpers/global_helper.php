<?php

use App\Models\NotificationUserModel;

function getAmountNotification($userId)
{
    $NotificationUserModel = new NotificationUserModel();
    return $NotificationUserModel->getUnreadCount($userId);
}

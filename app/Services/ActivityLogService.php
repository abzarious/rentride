<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Catat aktivitas user/admin secara terpusat dan aman.
     */
    public function log(string $action, string $description, ?string $subjectType = null, ?int $subjectId = null): ActivityLog
    {
        return ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'description'  => $description,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'ip_address'   => Request::ip(),
        ]);
    }
}
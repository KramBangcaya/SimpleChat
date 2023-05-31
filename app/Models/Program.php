<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Program extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity, SoftDeletes;
    protected $guard_name = 'api';
    protected $guarded = [];

    protected static $logName = 'program';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logAttributes = [
        'name',
        'code',
        'email',
        'category',
    ];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;
}

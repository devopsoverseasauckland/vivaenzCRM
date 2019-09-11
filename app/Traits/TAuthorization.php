<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;

use Auth;
use App\User;
use App\Role;

use DB;

trait TAuthorization {

    /// Provides the selection of the user to filter the visibility of advisories
    public function getUserFilter()
    {
        $roleId = Auth::user()->role_id;
        $role = Role::find($roleId);

        switch ($role->codigo)
        {
            case "GM":
            case "AD":
                $userId = 'NULL';
                break;
            default:
                $userId = auth()->user()->id;
                break;
        }

        return $userId;
    }

}
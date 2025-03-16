<?php

namespace App\Helpers;

class StatusHelper
{
    public static function status($status){
        if($status == 'ACTIVE'){
            return '<span class="badge badge-success">ACTIVE</span>';
        }else if($status == 'INACTIVE'){
            return '<span class="badge badge-danger">INACTIVE</span>';
        }else{
            return $status;
        }
    }
}
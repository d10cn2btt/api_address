<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class BaseResource extends JsonResource
{
    /**
     * Remove 'data' wrap in response by setting static::$wrap = null
     *
     * @see JsonResource@withoutWrapping
     *
     */
    public static $wrap = null;
}

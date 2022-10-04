<?php

namespace App\Support;

use App\Models\Settings as DB;
use Cache;

class Settings
{
    public $application_name = 'Cronus';
    protected $minutes = 2880;

    function check($key, $value)
    {
        $f = $this->get($key);
        return $f == $value;
    }

    function get($key)
    {
        $found = Cache::remember($this->getCacheKey($key), $this->minutes, function () use ($key) {
            return DB::where('key', $key)->first();
        });

        if ($found) {
            return $found->value;
        }

        return null;
    }

    protected function getCacheKey($key)
    {
        return 'cronus.' . (auth()->user() ? auth()->user()->id : '') . $key;
    }

    function getMany($keys)
    {
        $collection = [];
        foreach ($keys as $key) {
            $collection[$key] = $this->get($key);
        }

        return $collection;
    }

    function setMany($array)
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set($key, $value)
    {
        Cache::forget($this->getCacheKey($key));
        $instance = DB::firstOrNew(['key' => $key]);
        return $instance->fill(['value' => $value])
            ->save();
    }
}

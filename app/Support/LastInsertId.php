<?php


namespace App\Support;

use Illuminate\Support\Facades\DB;

trait LastInsertId
{
    protected static function bootLastInsertId()
    {
        static::created(function ($model) {
            $model->id = DB::select('SELECT @lastInsertId_' . str_replace('vw_', '', $model->getTable()) . ' AS id')[0]->id;
        });
    }
}

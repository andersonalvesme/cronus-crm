<?php

namespace App\Models\Template;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use LastInsertId;

    protected $table = 'vw_template_pages';

    protected $fillable = [
        'name', 'title', 'orientation', 'instruction',
        'page_html', 'content_fields', 'user_fields',
        'index', 'header_and_footer'
    ];


    public function getContentFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getUserFieldsAttribute($value)
    {
        return json_decode($value, true);
    }
}

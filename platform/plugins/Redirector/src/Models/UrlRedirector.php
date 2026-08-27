<?php

namespace ArchiElite\UrlRedirector\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;

class UrlRedirector extends BaseModel
{
    protected $table = 'url_redirector';

    protected $fillable = [
        'original',
        'target',
        'visits',
        'is_canonical',
        'is_410',
        'is_404',
        'is_500',
        'is_nofollow',
        'is_noindex',
    ];

    protected $casts = [
        'original' => SafeContent::class,
        'target' => SafeContent::class,
        'visits' => 'int',
        'is_canonical' => 'bool',
        'is_410' => 'bool',
        'is_404' => 'bool',
        'is_500' => 'bool',
        'is_nofollow' => 'bool',
        'is_noindex' => 'bool',
    ];

}

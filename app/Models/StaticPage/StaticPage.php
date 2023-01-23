<?php

namespace App\Models\StaticPage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticPage
 * @package App\Models\StaticPage
 */
class StaticPage extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'static_page';

    protected $dateFormat = 'U';
}

<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CachedUntil
 * @package SeIT\Models
 */
class CachedUntil extends Model
{
    protected $table = 'cached_until';
    protected $fillable = array('keyID', 'api', 'scope', 'hash', 'cached_until');
}

<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EveCharacterBlueprint
 * @package SeIT\Models
 */
class EveCharacterBlueprints extends Model
{
    use SoftDeletes;
    protected $table = 'eve_character_blueprints';
    protected $dates = ['deleted_at'];
}

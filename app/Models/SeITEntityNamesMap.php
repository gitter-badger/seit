<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SeITEntityNamesMap
 * @package SeIT\Models
 * @property int entityID
 * @property string entityName
 * @property bool resolved 
 */
class SeITEntityNamesMap extends Model
{
    protected $table = 'seit_entity_names_map';
}

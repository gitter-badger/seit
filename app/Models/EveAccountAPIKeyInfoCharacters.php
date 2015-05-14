<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EveAccountAPIKeyInfoCharacters
 * @package SeIT\Models
 */
class EveAccountAPIKeyInfoCharacters extends Model
{
    protected $table = 'eve_account_apikeyinfo_characters';
    protected $fillable = array('keyID', 'characterID', 'characterName', 'corporationID', 'corporationName');
}

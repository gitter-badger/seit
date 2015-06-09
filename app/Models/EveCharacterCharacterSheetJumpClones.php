<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EveCharacterCharacterSheetJumpClones
 * @package SeIT\Models
 * @propery int characterID
 * @propery int jumpCloneID
 * @propery int typeID
 * @propery int locationID
 * @propery string cloneName
 */
class EveCharacterCharacterSheetJumpClones extends Model
{
    protected $table = 'eve_character_sheet_jumpclones';
}

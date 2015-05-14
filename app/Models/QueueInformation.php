<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QueueInformation
 * @package SeIT\Models
 */
class QueueInformation extends Model
{
    protected $table = 'queue_information';
    protected $fillable = array('jobID', 'command', 'keyID', 'api', 'scope', 'type');
}

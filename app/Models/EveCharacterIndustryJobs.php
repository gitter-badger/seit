<?php namespace SeIT\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EveCharacterBlueprints
 * @package SeIT\Models
 */
class EveCharacterIndustryJobs extends Model
{
    use SoftDeletes;
    protected $table = 'eve_character_industryjobs';
    protected $dates = ['deleted_at'];
}

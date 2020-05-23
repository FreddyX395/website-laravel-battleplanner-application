<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

// Models
use App\Models\Gadget;
use App\Models\OperatorSlot;
use App\Models\Media;

class Operator extends Model
{
  protected $fillable = [
    // Properties
    'name', 'colour', 'attacker',

    // Fkey
    'icon_id'
  ];

  /**
   * Relationships
   */

  public function icon() {
    return $this->belongsTo(Media::class);
  }

  public function gadgets() {
    return $this->belongsToMany(Gadget::class);
  }

  public function slots() {
    return $this->belongsToMany(OperatorSlot::class);
  }

  public function media() {
    return $this->belongsTo(Media::class, 'media_id');
  }

  public static function create(array $attributes = []) {
    $media = Media::fromFile($attributes['icon'], "operators/{$attributes['name']}", "public");
    $attributes['media_id'] = $media->id;
    return static::query()->create($attributes);
  }

  /**
   * Scopes
   */
  public static function scopeAttackers($scope) {
    return $scope->where("attacker", true);
  }

  public static function scopeDefenders($scope) {
    return $scope->where("attacker", false);
  }
}

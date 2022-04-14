<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PersonNotification extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const STATUS_WAITING = 0;
    const STATUS_PROCCESS = 1;
    const STATUS_SENT = 2;

    protected $table = 'person_notifications';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function rss_item(){
        return $this->belongsTo(RssItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * @param Builder $query
     * @param  mixed  $type
     * @return Builder
     */
    public function scopeWhereByPersonId($query, $type){
        return $query->where('person_id', $type);
    }

    /**
     * @param Builder $query
     * @param  mixed  $type
     * @return Builder
     */
    public function scopeWhereByRssItemId($query, $type){
        return $query->where('rss_item_id', $type);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWhereToday($query){
        $today = now()->format('Y-m-d');
        return $query->where('created_at','>=', "${today} 00:00:00")->where('created_at','<=', "${today} 23:59:59");
    }

    /**
     * @param Builder $query
     * @param mixed $type
     * @return Builder
     */
    public function scopeWhereToStatus($query, $type){
        return $query->where('status', $type);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWhereActive($query){
        return $query->where('active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

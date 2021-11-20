<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PossibleDuplicate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id_left',
        'image_id_right',
        'is_false_positive',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    public function imageLeft()
    {
        return $this->belongsTo(Image::class, 'image_id_left');
    }

    public function imageRight()
    {
        return $this->belongsTo(Image::class, 'image_id_right');
    }
}

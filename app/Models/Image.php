<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property mixed $identifier_image
 * @property string $identifier
 * @property string|null $source
 * @property string $file_extension
 * @property int $file_size
 * @property int $width
 * @property int $height
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifierImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereWidth($value)
 * @mixin \Eloquent
 * @property string $mimetype
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereMimetype($value)
 */
class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source',
        'file_extension',
        'mimetype',
        'file_size',
        'width',
        'height',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'identifier',
        'identifier_image',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 24;

    public function getFileName()
    {
        return "{$this->id}.{$this->file_extension}";
    }

    public function getFilePath()
    {
        return Storage::disk('vk')->url($this->getFileName());
    }
}

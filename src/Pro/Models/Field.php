<?php

namespace LaraZeus\BoltPro\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Field preset model — stores saved field configurations for reuse.
 *
 * @property int $id
 * @property string $name
 * @property array $preset_data  JSON: { options: {}, sections: [ { name, fields: [] } ] }
 * @property string|null $description
 */
class Field extends Model
{
    use HasFactory;

    protected $table = 'bolt_field_presets';

    protected $guarded = [];

    protected $casts = [
        'preset_data' => 'array',
    ];
}

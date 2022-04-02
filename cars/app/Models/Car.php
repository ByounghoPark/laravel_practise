<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table='cars';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'founded', 'description', 'image_path', 'user_id'];

    protected $hidden = ['updated_at'];

    protected $visible = ['name', 'founded', 'description'];

    public function carmodels()
    {
        return $this->hasMany(CarModel::class);
    }

    // define a hasManyThrough relationship
    public function engines()
    {
        return $this->hasManyThrough(
            Engine::class,
            CarModel::class,
            'car_id',     // foreign key on CarModel table
            'model_id'    // foreign key on Engine table
        );
    }

    // define a hasOne relationship
    public function productionDate()
    {
        return $this->hasOneThrough(
            CarProductionDate::class,
            CarModel::class,
            'car_id',
            'model_id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

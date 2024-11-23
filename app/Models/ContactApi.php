<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation\BelongsTo;
use Illuminate\Database\Eloquent\Relation\HasMany;
use App\Models\User;
use App\Models\AddressApi;


class ContactApi extends Model
{
    use HasFactory;

    protected $table = "contact_apis";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = 
    [
        "name",
        "email",
        "phone",
    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::Class,"user_id","id");
    }

    public function address():hasMany
    {
        return $this->hasMany(Address::class,"contact_id","id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        "first_name",
        "last_name",
        "phone",
    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::Class,"user_id","id");
    }

    public function address():hasMany
    {
        return $this->hasMany(AddressApi::class,"contact_id","id");
    }
}

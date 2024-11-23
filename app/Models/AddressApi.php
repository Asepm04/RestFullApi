<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AddressApi;

class AddressApi extends Model
{
    use HasFactory;

    protected $table = "address_apis";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = 
    [
        "street",
        "city",
        "province",
        "country",
        "postal_code"
    ];

    public function contact():belongsTo
    {
        return $this->belongsTo(ContactApi::class,"contact_id","id");
    }
}

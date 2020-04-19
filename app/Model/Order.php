<?php namespace App\Model;

use App\Model\Code;
use App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'costumer_name',
        'costumer_email',
        'costumer_mobile',
        'status',
        'product_id',
        'request_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function status()
    {
        return  Code::where('code', $this->status)->where('group', 'ORDER_STATUS')->first();
    }
}

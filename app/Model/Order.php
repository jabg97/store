<?php namespace App\Model;

use App\Model\Code;
use App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;

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
        'request_expiration',
        'product_id',
        'request_id',
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

    public function notify($msg)
    {
        $data = array(
            'id' => $this->id,
            'costumer_name' => $this->costumer_name,
            'msg' => $msg,
            'product' => $this->product->name,
            'price' => $this->product->price,
            'status' => $this->status()->name,
            'link' => url('/') . "/order/" . $this->id,
        );

        $from_email = "horariotps@gmail.com";
        $from_name = "Store";
        Mail::send('email.notification', $data, function ($message) use ($from_email, $from_name) {
            $message->from($from_email, $from_name);
            $message->to($this->costumer_email, $this->costumer_name)->subject('Actualización de estado');
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function status()
    {
        return Code::where('code', $this->status)->where('group', 'ORDER_STATUS')->first();
    }
}

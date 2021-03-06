<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $no
 * @property int $user_id
 * @property array $address
 * @property string $total_amount
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $payment_method
 * @property string|null $payment_no
 * @property string $refund_status
 * @property string|null $refund_no
 * @property bool $closed
 * @property bool $reviewed
 * @property string $ship_status
 * @property array|null $ship_data
 * @property array|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefundStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $coupon_code_id
 * @property-read \App\Models\CouponCode|null $couponCode
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponCodeId($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereType($value)
 */
class Order extends BaseModel
{
    use HasFactory;

    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_APPLIED = 'applied';
    const REFUND_STATUS_PROCESSING = 'processing';
    const REFUND_STATUS_SUCCESS = 'success';
    const REFUND_STATUS_FAILED = 'failed';

    const SHIP_STATUS_PENDING = 'pending';
    const SHIP_STATUS_DELIVERED = 'delivered';
    const SHIP_STATUS_RECEIVED = 'received';

    const TYPE_NORMAL = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';

    public static $typeMap = [
        self::TYPE_NORMAL => '??????????????????',
        self::TYPE_CROWDFUNDING => '??????????????????',
    ];

    public static $refundStatusMap = [
        self::REFUND_STATUS_PENDING    => '?????????',
        self::REFUND_STATUS_APPLIED    => '???????????????',
        self::REFUND_STATUS_PROCESSING => '?????????',
        self::REFUND_STATUS_SUCCESS    => '????????????',
        self::REFUND_STATUS_FAILED     => '????????????',
    ];

    public static $shipStatusMap = [
        self::SHIP_STATUS_PENDING   => '?????????',
        self::SHIP_STATUS_DELIVERED => '?????????',
        self::SHIP_STATUS_RECEIVED  => '?????????',
    ];

    protected $fillable = [
        'type',
        'no',
        'address',
        'total_amount',
        'remark',
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
        'refund_no',
        'closed',
        'reviewed',
        'ship_status',
        'ship_data',
        'extra',
    ];

    protected $casts = [
        'closed'    => 'boolean',
        'reviewed'  => 'boolean',
        'address'   => 'json',
        'ship_data' => 'json',
        'extra'     => 'json',
    ];

    protected $dates = [
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ???????????? ????????? ???????????????
    // protected static function boot()
    // {
    //     parent::boot();
    //     // ?????????????????????????????????????????????????????????
    //     static::creating(function ($model) {
    //         // ??????????????? no ????????????
    //         if (!$model->no) {
    //             // ?????? findAvailableNo ?????????????????????
    //             $model->no = static::findAvailableNo();
    //             // ??????????????????????????????????????????
    //             if (!$model->no) {
    //                 return false;
    //             }
    //         }
    //     });
    // }

    public static function findAvailableNo()
    {
        // ?????????????????????
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // ???????????? 6 ????????????
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // ????????????????????????
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }

    public static function getAvailableRefundNo()
    {
        do {
            // Uuid???????????????????????????????????????????????????
            $no = Uuid::uuid4()->getHex();
            // ????????????????????????????????????????????????????????????????????????????????????????????????????????????
        } while (self::where('refund_no', $no)->exists());

        return $no;
    }

    public function couponCode()
    {
        return $this->belongsTo(CouponCode::class);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\InstallmentItem
 *
 * @property int $id
 * @property int $installment_id
 * @property int $sequence 还款顺序编号
 * @property string $base
 * @property string $fee
 * @property string|null $fine
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $payment_method
 * @property string|null $payment_no
 * @property string $refund_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $is_overdue
 * @property-read mixed $total
 * @property-read \App\Models\Installment $installment
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereFine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereInstallmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem wherePaymentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereRefundStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallmentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InstallmentItem extends BaseModel
{
    use HasFactory;

    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_PROCESSING = 'processing';
    const REFUND_STATUS_SUCCESS = 'success';
    const REFUND_STATUS_FAILED = 'failed';

    public static $refundStatusMap = [
        self::REFUND_STATUS_PENDING    => '未退款',
        self::REFUND_STATUS_PROCESSING => '退款中',
        self::REFUND_STATUS_SUCCESS    => '退款成功',
        self::REFUND_STATUS_FAILED     => '退款失败',
    ];

    protected $fillable = [
        'sequence',
        'base',
        'fee',
        'fine',
        'due_date',
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
    ];

    protected $dates = ['due_date', 'paid_at'];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    // 访问器，返回当前还款计划需还款的总金额
    public function getTotalAttribute()
    {
        // 小数点计算用到 moontoast/math 库提供的函数
        $total = big_number($this->base)->add($this->fee);
        if (!is_null($this->fine)) {
            $total->add($this->fine);
        }

        return $total->getValue();
    }

    // 访问器，返回当前还款计划是否已经逾期
    public function getIsOverdueAttribute()
    {
        return Carbon::now()->gt($this->due_date);
    }
}

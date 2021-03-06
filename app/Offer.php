<?php namespace Koolbeans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['coffee_shop_id', 'product_id', 'finish_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coffee_shop()
    {
        return $this->belongsTo(CoffeeShop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(OfferDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        $detail = $this->details()->first();
        if ($detail->type == 'free') {
            return 'FREE';
        }

        if ($detail->amount_xs) {
            $amount = $detail->amount_xs;
        } elseif ($detail->amount_sm) {
            $amount = $detail->amount_sm;
        } elseif ($detail->amount_sm) {
            $amount = $detail->amount_md;
        } else {
            $amount = $detail->amount_lg;
        }

        if ($detail->type == 'flat') {
            return '£ ' . number_format($amount / 100, 2) . ' off';
        }

        return $amount . '% off';
    }

    /**
     * @return Product
     */
    public function productOnDeal()
    {
        $detail = $this->details()->first();

        return $detail->product ? $detail->product : $this->product;
    }

}

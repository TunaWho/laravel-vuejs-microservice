<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property      int $id
 * @property      string $first_name
 * @property      string $last_name
 * @property      string $email
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @method        static \Database\Factories\OrderFactory factory(...$parameters)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method        static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method        static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereFirstName($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereLastName($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @mixin         \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Get all of the order items for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get total order items
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): Attribute
    {
        return Attribute::get(
            fn ()                    => $this->orderItems->sum(
                fn (OrderItem $item) => $item->price * $item->quantity
            )
        );
    }

    /**
     * Returns the first name and last name of the user
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::get(
            fn () => $this->first_name . ' ' . $this->last_name
        );
    }
}

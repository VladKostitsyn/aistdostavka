<?php


namespace App\Export;

use App\Models\Order as Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class OrderExport implements ShouldAutoSize,WithHeadings,FromQuery
{
    use Exportable;
    public function headings(): array
    {
        return [
            'Заказ',
            'Дата создания',
            'Название',
            'Статус заказа',
            'Цена',
            'Заметки',
            'Метод',
            'Пользователь',
        ];
    }
    public function query()
    {
        return Order::query()->join("food_orders", "orders.id", "=", "food_orders.order_id")
            ->join("order_statuses", "orders.order_status_id", "=", "order_statuses.id")
            ->join("foods", "foods.id", "=", "food_orders.food_id")
            ->join("restaurants", "foods.restaurant_id", "=", "restaurants.id")
            ->join("payments", "orders.payment_id", "=", "payments.id")
            ->join("user_restaurants", "user_restaurants.restaurant_id", "=", "foods.restaurant_id")
            ->join("users", "orders.user_id", "=", "users.id")
            ->groupBy('orders.id')
            ->select(['orders.id','orders.created_at','restaurants.name','order_statuses.status','payments.price','orders.hint','payments.method','users.phone'])
            ->take(600);
    }
}
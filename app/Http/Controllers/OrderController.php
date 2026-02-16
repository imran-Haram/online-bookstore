<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Show checkout page (summary of cart)
    public function create()
    {
        $user  = auth()->user();
        $items = $user->cartItems()->with('book')->get();

        if ($items->isEmpty()) {
            return redirect()->route('books.index')
                ->with('success', 'Your cart is empty.');
        }

        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('checkout.create', compact('items', 'total'));
    }

    // Place order
    public function store(Request $request)
    {
        $user  = auth()->user();
        $items = $user->cartItems()->with('book')->get();

        if ($items->isEmpty()) {
            return redirect()->route('books.index')
                ->with('success', 'Your cart is empty.');
        }

        DB::transaction(function () use ($user, $items, &$order) {
            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total'   => $total,
                'status'  => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'book_id'    => $item->book_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'line_total' => $item->price * $item->quantity,
                ]);
            }

            // clear cart
            CartItem::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    // List orders for logged-in user
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Show single order
    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.book');

        return view('orders.show', compact('order'));
    }
}

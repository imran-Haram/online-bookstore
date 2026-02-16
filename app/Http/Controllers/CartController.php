<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()
            ->cartItems()
            ->with('book')
            ->get();

        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Book $book)
    {
        $user = auth()->user();

        $item = CartItem::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'user_id'  => $user->id,
                'book_id'  => $book->id,
                'quantity' => 1,
                'price'    => $book->price,
            ]);
        }

        return redirect()->back()->with('success', 'Book added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->authorizeItem($cartItem);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeItem($cartItem);

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    protected function authorizeItem(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }
    }
}

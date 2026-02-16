<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total'),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_users'));
    }

    // User Management
    public function users()
    {
        $users = User::with('orders')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load('orders.orderItems.book');
        return view('admin.users.show', compact('user'));
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // Order Management
    public function orders()
    {
        $orders = Order::with('user', 'orderItems.book')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('user', 'orderItems.book');
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // Book Management (Admin view)
    public function books()
    {
        $books = Book::latest()->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function createBook()
    {
        return view('admin.books.create');
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_url'   => 'nullable|url',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books')->with('success', 'Book created successfully.');
    }

    public function editBook(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_url'   => 'nullable|url',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books')->with('success', 'Book updated successfully.');
    }

    public function destroyBook(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books')->with('success', 'Book deleted successfully.');
    }
}

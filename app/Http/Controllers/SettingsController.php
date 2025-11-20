<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Admin doesn't need category management, only users do
        if (auth()->user()->role->value === 'admin') {
            return view('settings.index-admin');
        }
        
        $categories = Category::forUser(auth()->id())->get();
        
        return view('settings.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:income,expense'],
            'icon' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:20'],
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'type' => $request->type,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_default' => false,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:20'],
        ]);

        $category = Category::forUser(auth()->id())->findOrFail($id);

        $category->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'color' => $request->color,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory($id)
    {
        $category = Category::forUser(auth()->id())->findOrFail($id);

        if ($category->is_default) {
            return back()->with('error', 'Kategori default tidak bisa dihapus!');
        }

        // Check if category has transactions
        if ($category->transactions()->count() > 0) {
            return back()->with('error', 'Kategori ini masih memiliki transaksi!');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}

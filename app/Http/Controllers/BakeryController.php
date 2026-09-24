<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BakeryModel;
use App\Models\Category;
use App\Models\Product;
class BakeryController extends Controller
{
    public $bakeryMenus = [];

    function createBakeryForm()
    {
        return view('createBakery');
    }

    function storeBakeryItem(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'brand' => 'required|string|max:255',
            'image_url' => ['nullable', 'required_without:image_file', 'url'],
            'image_file' => ['nullable', 'required_without:image_url', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'flavor' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $brandValue = is_array($request->input('brand'))
            ? implode(',', $request->input('brand'))
            : trim((string) $validatedData['brand']);

        $flavorValue = is_array($request->input('flavor'))
            ? implode(',', $request->input('flavor'))
            : trim((string) ($validatedData['flavor'] ?? ''));

        $imageValue = $validatedData['image_url'] ?? null;

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('bakery', 'public');
            $imageValue = Storage::disk('public')->url($path);
        }

        BakeryModel::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'brand' => $brandValue,
            'image' => $imageValue,
            'flavor' => $flavorValue !== '' ? $flavorValue : null,
            'description' => $validatedData['description'] ?? null,
        ]);

        return redirect('/bakery')->with('success', 'Bakery item created successfully!');
    }

    function DisplayBakeryMenu(Request $request)
    {
        $query = Product::with('category', 'images')->where('status', 'active');
        $selectedCategory = null;

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->query('category'))->firstOrFail();
            $query->where('category_id', $category->id);
            $selectedCategory = $category->slug;
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($productQuery) use ($search) {
                $productQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return view('customer.storefront', [
            'categories' => Category::latest()->get(),
            'products' => $query->latest()->paginate(4),
            'selectedCategory' => $selectedCategory,
        ]);
    }

    function deleteBakeryItem($id)
    {
        $bakeryItem = BakeryModel::findOrFail($id);
        $bakeryItem->delete();

        return redirect()->route('bakery.menu')->with('success', 'Bakery item deleted successfully!');
    }

    function editBakeryItem($id)
    {
        $bakeryItem = BakeryModel::findOrFail($id);
        return view('editBakery', ['bakeryItem' => $bakeryItem]);
    }

    function updateBakeryItem(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'brand' => 'nullable|string|max:255',
            'flavor' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $bakeryItem = BakeryModel::findOrFail($id);
        $bakeryItem->name = $validatedData['name'];
        $bakeryItem->price = $validatedData['price'];
        $bakeryItem->brand = $validatedData['brand'] ?? $bakeryItem->brand;
        $bakeryItem->flavor = $validatedData['flavor'] ?? $bakeryItem->flavor;
        $bakeryItem->description = $validatedData['description'] ?? $bakeryItem->description;
        $bakeryItem->save();

        return redirect()->route('bakery.menu')->with('success', 'Bakery item updated successfully!');
    }
}

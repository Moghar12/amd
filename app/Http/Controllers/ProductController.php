<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Récupérer tous les produits avec leurs catégories associées
        $products = Product::with('category')
            ->latest() 
            ->get();
    
        return view('products.index', compact('products'));
    }
    

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'purchase_price' => 'required|numeric',
        'pph_ttc' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'quantity' => 'integer|min:0', // Ajout de la validation pour la quantité
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'image.required' => 'The image field is required when uploading an image.',
    ]);

    $category = Category::findOrFail($request->input('category_id'));
    $productCount = $category->products()->count();
    $productCode = $category->code . ($productCount + 1);

    $productData = [
        'name' => $request->input('name'),
        'purchase_price' => $request->input('purchase_price'),
        'category_id' => $request->input('category_id'),
        'product_code' => $productCode,
        'quantity' => $request->input('quantity') ?? 0, // Ajout de la quantité dans les données du produit
        'price_with_taxes' => $request->input('purchase_price') * 1.2, // Enregistrement du prix d'achat TTC
        'pph_ttc' => $request->input('pph_ttc'),
        'tva' => 20,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $productData['image'] = $imageName;
    }

    $product = Product::create($productData);

    return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
}

    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès..');
}

public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all();

    return view('products.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'purchase_price' => 'required|numeric',
        'pph_ttc' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'image.required' => 'The image field is required when uploading an image.',
    ]);

    $product = Product::findOrFail($id);
    $category = Category::findOrFail($request->input('category_id'));
    $productCount = $category->products()->count();
    $productCode = $category->code . ($productCount + 1);

    $product->name = $request->input('name');
    $product->purchase_price = $request->input('purchase_price');
    $product->category_id = $request->input('category_id');
    $product->product_code = $productCode;
    $product->quantity = $request->input('quantity');
    $product->price_with_taxes = $request->input('purchase_price') * 1.2;
    $product->pph_ttc = $request->input('pph_ttc');
    $product->tva = 20;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->route('products.index')->with('success', 'Produit modifié avec succès.');
}



}

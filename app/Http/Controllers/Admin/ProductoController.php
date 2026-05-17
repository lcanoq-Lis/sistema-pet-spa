<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos  = Producto::with('categoria')->orderBy('nombre')->get();
        $bajoStock  = $productos->filter(fn($p) => $p->bajoPorStock());

        return view('admin.productos.index', compact('productos', 'bajoStock'));
    }

    public function create()
    {
        $categorias = CategoriaProducto::where('activo', true)->get();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:150',
            'sku'         => 'required|string|max:100|unique:productos,sku',
            'precio_base' => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'stock_minimo'=> 'required|integer|min:0',
            'categoria_id'=> 'nullable|exists:categorias_productos,id',
        ]);

        Producto::create($request->all() + ['activo' => true]);

        return redirect()->route('admin.productos.index')
            ->with('status', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto   = Producto::findOrFail($id);
        $categorias = CategoriaProducto::where('activo', true)->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:150',
            'sku'         => 'required|string|max:100|unique:productos,sku,' . $id,
            'precio_base' => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'stock_minimo'=> 'required|integer|min:0',
            'categoria_id'=> 'nullable|exists:categorias_productos,id',
        ]);

        $producto->update($request->all());

        return redirect()->route('admin.productos.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->activo = false;
        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('status', 'Producto desactivado correctamente.');
    }
}
<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::where('activo', true)->with('categoria');

        if ($request->categoria) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->buscar) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $productos  = $query->orderBy('nombre')->get();
        $categorias = CategoriaProducto::where('activo', true)->get();

        return view('cliente.tienda.index', compact('productos', 'categorias'));
    }
}
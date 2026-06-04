<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Cupon;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::obtenerOCrear(Auth::id());
        $carrito->load('items.producto', 'cupon');
        return view('cliente.carrito.index', compact('carrito'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if (!$producto->activo || $producto->stock < $request->cantidad) {
            return back()->with('error', 'Producto no disponible o sin stock suficiente.');
        }

        $carrito = Carrito::obtenerOCrear(Auth::id());

        $item = $carrito->items()->where('producto_id', $producto->id)->first();

        if ($item) {
            $nuevaCantidad = $item->cantidad + $request->cantidad;
            if ($nuevaCantidad > $producto->stock) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            $item->update(['cantidad' => $nuevaCantidad]);
        } else {
            $carrito->items()->create([
                'producto_id'     => $producto->id,
                'cantidad'        => $request->cantidad,
                'precio_unitario' => $producto->precio_base,
            ]);
        }

        return back()->with('status', '✅ Producto agregado al carrito.');
    }

    public function actualizar(Request $request, $itemId)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);

        $carrito = Carrito::obtenerOCrear(Auth::id());
        $item = $carrito->items()->findOrFail($itemId);

        if ($request->cantidad > $item->producto->stock) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        $item->update(['cantidad' => $request->cantidad]);
        return back()->with('status', 'Cantidad actualizada.');
    }

    public function eliminar($itemId)
    {
        $carrito = Carrito::obtenerOCrear(Auth::id());
        $carrito->items()->findOrFail($itemId)->delete();
        return back()->with('status', 'Producto eliminado del carrito.');
    }

    public function aplicarCupon(Request $request)
    {
        $request->validate(['codigo' => 'required|string']);

        $cupon = Cupon::where('codigo', strtoupper($request->codigo))->first();

        if (!$cupon || !$cupon->esValido()) {
            return back()->with('error', '❌ Cupón inválido o expirado.');
        }

        $carrito = Carrito::obtenerOCrear(Auth::id());
        $carrito->load('items');
        $subtotal = $carrito->subtotal();

        if ($subtotal < $cupon->minimo_compra) {
            return back()->with('error', "❌ El cupón requiere un mínimo de Bs. {$cupon->minimo_compra}.");
        }

        $descuento = $cupon->calcularDescuento($subtotal);
        $carrito->update(['cupon_id' => $cupon->id, 'descuento' => $descuento]);

        return back()->with('status', "✅ Cupón aplicado. Descuento: Bs. {$descuento}");
    }

    public function quitarCupon()
    {
        $carrito = Carrito::obtenerOCrear(Auth::id());
        $carrito->update(['cupon_id' => null, 'descuento' => 0]);
        return back()->with('status', 'Cupón eliminado.');
    }

    public function confirmar()
    {
        $carrito = Carrito::obtenerOCrear(Auth::id());
        $carrito->load('items.producto', 'cupon');

        if ($carrito->items->isEmpty()) {
            return back()->with('error', 'El carrito está vacío.');
        }

        // Armar mensaje WhatsApp
        $lineas = ["🛒 *Pedido Pet Spa*\n"];
        foreach ($carrito->items as $item) {
            $lineas[] = "• {$item->producto->nombre} x{$item->cantidad} = Bs. " . number_format($item->subtotal(), 2);
        }
        $lineas[] = "\n💰 *Subtotal:* Bs. " . number_format($carrito->subtotal(), 2);
        if ($carrito->descuento > 0) {
            $lineas[] = "🎫 *Descuento:* -Bs. " . number_format($carrito->descuento, 2);
        }
        $lineas[] = "✅ *Total:* Bs. " . number_format($carrito->total(), 2);

        $mensaje = implode("\n", $lineas);
        $url = 'https://wa.me/59174260228?text=' . urlencode($mensaje);

        // Vaciar carrito
        $carrito->items()->delete();
        $carrito->update(['cupon_id' => null, 'descuento' => 0]);

        return redirect($url);
    }
}

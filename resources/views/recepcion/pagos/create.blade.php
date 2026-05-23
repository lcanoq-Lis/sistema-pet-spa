@extends('layouts.dashboard')
@section('page-title', '💳 Registrar Pago')
@section('page-subtitle', 'Cita #{{ $cita->id }} — {{ $cita->mascota->nombre }}')

@section('content')
<div style="max-width:560px; margin:0 auto;">

@if($errors->any())
    <div style="background:#ffebee; color:#c62828; border-left:4px solid #e53935; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        {{ $errors->first() }}
    </div>
@endif

{{-- Resumen de la cita --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:20px; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#1565c0,#1976d2); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">📋</span>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Resumen de la cita</h3>
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Revisa los detalles antes de registrar el pago</p>
        </div>
    </div>
    <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <div>
            <p style="font-size:11px; color:#a1887f; font-weight:600; margin:0 0 2px;">MASCOTA</p>
            <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0;">{{ $cita->mascota->nombre }}</p>
            <p style="font-size:12px; color:#a1887f; margin:0;">{{ ucfirst($cita->mascota->especie) }} · {{ $cita->mascota->raza }}</p>
        </div>
        <div>
            <p style="font-size:11px; color:#a1887f; font-weight:600; margin:0 0 2px;">SERVICIO</p>
            <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0;">{{ $cita->servicio->nombre }}</p>
            <p style="font-size:12px; color:#a1887f; margin:0;">{{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
        </div>
        <div>
            <p style="font-size:11px; color:#a1887f; font-weight:600; margin:0 0 2px;">GROOMER</p>
            <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0;">{{ $cita->groomer?->nombre ?? 'No asignado' }}</p>
        </div>
        <div>
            <p style="font-size:11px; color:#a1887f; font-weight:600; margin:0 0 2px;">PRECIO BASE</p>
            <p style="font-size:18px; font-weight:700; color:#ff7043; margin:0;">Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
        </div>
    </div>
</div>

{{-- Formulario de pago --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">💳</span>
        <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Registrar pago</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.pagos.store', $cita->id) }}" style="padding:20px;">
        @csrf

        {{-- Método de pago --}}
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:10px;">Método de pago *</label>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="efectivo" checked style="display:none;" onchange="actualizarMetodo()">
                    <div id="btn-efectivo"
                        onclick="seleccionarMetodo('efectivo')"
                        style="border:2px solid #ff7043; background:#fff8f5; border-radius:12px; padding:16px 10px; text-align:center; transition:all 0.2s;">
                        <div style="font-size:28px;">💵</div>
                        <p style="font-size:13px; font-weight:600; color:#ff7043; margin:6px 0 0;">Efectivo</p>
                    </div>
                </label>
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="qr" style="display:none;">
                    <div id="btn-qr"
                        onclick="seleccionarMetodo('qr')"
                        style="border:2px solid #d7ccc8; background:white; border-radius:12px; padding:16px 10px; text-align:center; transition:all 0.2s;">
                        <div style="font-size:28px;">📱</div>
                        <p style="font-size:13px; font-weight:600; color:#a1887f; margin:6px 0 0;">QR</p>
                    </div>
                </label>
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="transferencia" style="display:none;">
                    <div id="btn-transferencia"
                        onclick="seleccionarMetodo('transferencia')"
                        style="border:2px solid #d7ccc8; background:white; border-radius:12px; padding:16px 10px; text-align:center; transition:all 0.2s;">
                        <div style="font-size:28px;">🏦</div>
                        <p style="font-size:13px; font-weight:600; color:#a1887f; margin:6px 0 0;">Transferencia</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Referencia (solo para QR y transferencia) --}}
        <div id="campo-referencia" style="display:none; margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                Nro. de referencia / comprobante
            </label>
            <input type="text" name="referencia" maxlength="100"
                placeholder="Ej: TRX-2026-00123"
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
        </div>

        {{-- Descuento --}}
        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                Descuento (Bs.) <span style="color:#a1887f; font-weight:400;">— opcional</span>
            </label>
            <input type="number" name="descuento" id="input-descuento" min="0"
                max="{{ $cita->precio_acordado }}" step="0.01" value="0"
                oninput="calcularTotal()"
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
        </div>

        {{-- Total calculado --}}
        <div style="background:#f5f0eb; border-radius:12px; padding:16px 20px; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:14px; font-weight:600; color:#5d4037;">Total a cobrar:</span>
            <span id="total-display" style="font-size:24px; font-weight:700; color:#ff7043;">
                Bs. {{ number_format($cita->precio_acordado, 2) }}
            </span>
        </div>

        {{-- Observaciones --}}
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                Observaciones <span style="color:#a1887f; font-weight:400;">— opcional</span>
            </label>
            <textarea name="observaciones" rows="2" maxlength="300"
                placeholder="Notas adicionales sobre el pago..."
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; resize:vertical; box-sizing:border-box;"></textarea>
        </div>
        {{-- Sección promoción --}}
<div style="margin-bottom:16px;">
    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:8px;">
        🏷️ Aplicar promoción <span style="color:#a1887f; font-weight:400;">(opcional)</span>
    </label>
    <select id="select-promo" name="promocion_id"
        onchange="aplicarPromocion(this.value)"
        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; background:white; box-sizing:border-box;">
        <option value="">— Sin promoción —</option>
        @foreach($promociones as $promo)
            <option value="{{ $promo->id }}"
                data-valor="{{ $promo->calcularDescuento($cita->precio_acordado) }}">
                {{ $promo->nombre }} — {{ $promo->tipo_label }}
                @if($promo->servicio && $promo->servicio_id != $cita->servicio_id)
                    (no aplica a este servicio)
                @endif
            </option>
        @endforeach
    </select>
    <div id="promo-msg" style="display:none; margin-top:6px; padding:8px 12px; border-radius:8px; font-size:12px;"></div>
</div>


        <div style="display:flex; gap:10px;">
            <a href="{{ route('recepcion.citas.index') }}"
                style="flex:1; text-align:center; padding:12px; border-radius:10px; background:#f5f0eb; color:#8d6e63; font-weight:600; font-size:14px; text-decoration:none;">
                Cancelar
            </a>
            <button type="submit"
                style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif; box-shadow:0 2px 8px rgba(255,112,67,0.4);">
                ✅ Confirmar pago
            </button>
        </div>
    </form>
</div>
</div>

<script>
const precioBase = {{ $cita->precio_acordado }};
let metodoActual = 'efectivo';

function seleccionarMetodo(metodo) {
    metodoActual = metodo;
    ['efectivo','qr','transferencia'].forEach(m => {
        const btn = document.getElementById('btn-' + m);
        const radio = document.querySelector(`input[value="${m}"]`);
        if (m === metodo) {
            btn.style.borderColor = '#ff7043';
            btn.style.background  = '#fff8f5';
            btn.querySelector('p').style.color = '#ff7043';
            radio.checked = true;
        } else {
            btn.style.borderColor = '#d7ccc8';
            btn.style.background  = 'white';
            btn.querySelector('p').style.color = '#a1887f';
            radio.checked = false;
        }
    });
    document.getElementById('campo-referencia').style.display =
        (metodo === 'qr' || metodo === 'transferencia') ? 'block' : 'none';
}

function calcularTotal() {
    const descuento = parseFloat(document.getElementById('input-descuento').value) || 0;
    const total = Math.max(0, precioBase - descuento);
    document.getElementById('total-display').textContent = 'Bs. ' + total.toFixed(2);
}
</script>
@endsection

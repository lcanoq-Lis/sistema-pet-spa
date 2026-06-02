@extends('layouts.dashboard')
@section('page-title', 'Registrar Pago')
@section('page-subtitle', 'Cita #{{ $cita->id }} — {{ $cita->mascota->nombre }}')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:500; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

{{-- Resumen de la cita --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; margin-bottom:24px; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1565C0, #0D3B5E); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <i class="ti ti-clipboard-list" style="font-size:20px; color:#fff;"></i>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Resumen de la cita</h3>
            <p style="font-size:11px; color:#BBDEFB; margin:0;">Revisa los detalles antes de registrar el pago</p>
        </div>
    </div>
    <div style="padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div>
            <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 5px;">
                <i class="ti ti-dog" style="font-size:10px;"></i> MASCOTA
            </p>
            <p style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">{{ $cita->mascota->nombre }}</p>
            <p style="font-size:12px; color:#8A9B8A; margin:2px 0 0;">{{ ucfirst($cita->mascota->especie) }} · {{ $cita->mascota->raza }}</p>
        </div>
        <div>
            <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 5px;">
                <i class="ti ti-scissors" style="font-size:10px;"></i> SERVICIO
            </p>
            <p style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">{{ $cita->servicio->nombre }}</p>
            <p style="font-size:12px; color:#8A9B8A; margin:2px 0 0;">
                <i class="ti ti-calendar" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}
            </p>
        </div>
        <div>
            <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 5px;">
                <i class="ti ti-user" style="font-size:10px;"></i> GROOMER
            </p>
            <p style="font-size:14px; font-weight:600; color:#1A2E1A; margin:0;">{{ $cita->groomer?->nombre ?? 'No asignado' }}</p>
        </div>
        <div>
            <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 5px;">
                <i class="ti ti-coin" style="font-size:10px;"></i> PRECIO BASE
            </p>
            <p style="font-size:22px; font-weight:800; color:#FF7043; margin:0;">Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
        </div>
    </div>
</div>

{{-- Formulario de pago --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #FF7043, #F57F17); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <i class="ti ti-cash" style="font-size:20px; color:#fff;"></i>
        <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Registrar pago</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.pagos.store', $cita->id) }}" style="padding:24px;">
        @csrf

        {{-- Método de pago --}}
        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:12px; text-transform:uppercase;">
                <i class="ti ti-credit-card" style="font-size:12px;"></i> Método de pago *
            </label>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="efectivo" checked style="display:none;" onchange="actualizarMetodo()">
                    <div id="btn-efectivo" onclick="seleccionarMetodo('efectivo')"
                        style="border:2px solid #FF7043; background:#FFF8F5; border-radius:16px; padding:14px 10px; text-align:center; transition:all 0.2s; cursor:pointer;">
                        <i class="ti ti-cash" style="font-size:28px; color:#FF7043; display:block;"></i>
                        <p style="font-size:12px; font-weight:700; color:#FF7043; margin:8px 0 0;">Efectivo</p>
                    </div>
                </label>
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="qr" style="display:none;">
                    <div id="btn-qr" onclick="seleccionarMetodo('qr')"
                        style="border:2px solid #e0e0e0; background:#fff; border-radius:16px; padding:14px 10px; text-align:center; transition:all 0.2s; cursor:pointer;">
                        <i class="ti ti-qrcode" style="font-size:28px; color:#8A9B8A; display:block;"></i>
                        <p style="font-size:12px; font-weight:600; color:#8A9B8A; margin:8px 0 0;">QR</p>
                    </div>
                </label>
                <label style="cursor:pointer;">
                    <input type="radio" name="metodo" value="transferencia" style="display:none;">
                    <div id="btn-transferencia" onclick="seleccionarMetodo('transferencia')"
                        style="border:2px solid #e0e0e0; background:#fff; border-radius:16px; padding:14px 10px; text-align:center; transition:all 0.2s; cursor:pointer;">
                        <i class="ti ti-transfer" style="font-size:28px; color:#8A9B8A; display:block;"></i>
                        <p style="font-size:12px; font-weight:600; color:#8A9B8A; margin:8px 0 0;">Transferencia</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Referencia (solo para QR y transferencia) --}}
        <div id="campo-referencia" style="display:none; margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-hash" style="font-size:12px;"></i> Nro. de referencia / comprobante
            </label>
            <input type="text" name="referencia" maxlength="100" placeholder="Ej: TRX-2026-00123"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        {{-- Descuento --}}
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-discount" style="font-size:12px;"></i> Descuento (Bs.)
                <span style="color:#8A9B8A; font-weight:400;">— opcional</span>
            </label>
            <input type="number" name="descuento" id="input-descuento" min="0" max="{{ $cita->precio_acordado }}" step="0.01" value="0"
                oninput="calcularTotal()"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        {{-- Promoción --}}
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-tag" style="font-size:12px;"></i> Aplicar promoción
                <span style="color:#8A9B8A; font-weight:400;">(opcional)</span>
            </label>
            <select id="select-promo" name="promocion_id" onchange="aplicarPromocion(this.value)"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer;">
                <option value="">— Sin promoción —</option>
                @foreach($promociones as $promo)
                    <option value="{{ $promo->id }}" data-valor="{{ $promo->calcularDescuento($cita->precio_acordado) }}">
                        {{ $promo->nombre }} — {{ $promo->tipo_label }}
                        @if($promo->servicio && $promo->servicio_id != $cita->servicio_id)
                            (no aplica a este servicio)
                        @endif
                    </option>
                @endforeach
            </select>
            <div id="promo-msg" style="display:none; margin-top:8px; padding:8px 12px; border-radius:10px; font-size:11px;"></div>
        </div>

        {{-- Total calculado --}}
        <div style="background:#F5F5F0; border-radius:16px; padding:18px 24px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:14px; font-weight:700; color:#1A2E1A;">Total a cobrar:</span>
            <span id="total-display" style="font-size:28px; font-weight:800; color:#FF7043;">
                Bs. {{ number_format($cita->precio_acordado, 2) }}
            </span>
        </div>

        {{-- Observaciones --}}
        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-notes" style="font-size:12px;"></i> Observaciones
                <span style="color:#8A9B8A; font-weight:400;">— opcional</span>
            </label>
            <textarea name="observaciones" rows="2" maxlength="300" placeholder="Notas adicionales sobre el pago..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
        </div>

        <div style="display:flex; gap:12px;">
            <a href="{{ route('recepcion.citas.index') }}"
                style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
            </a>
            <button type="submit"
                style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                <i class="ti ti-check" style="font-size:14px;"></i> Confirmar pago
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
            btn.style.borderColor = '#FF7043';
            btn.style.background  = '#FFF8F5';
            btn.style.borderWidth = '2px';
            const icon = btn.querySelector('i');
            if(icon) icon.style.color = '#FF7043';
            const p = btn.querySelector('p');
            if(p) { p.style.color = '#FF7043'; p.style.fontWeight = '700'; }
            if(radio) radio.checked = true;
        } else {
            btn.style.borderColor = '#e0e0e0';
            btn.style.background  = '#fff';
            btn.style.borderWidth = '1.5px';
            const icon = btn.querySelector('i');
            if(icon) icon.style.color = '#8A9B8A';
            const p = btn.querySelector('p');
            if(p) { p.style.color = '#8A9B8A'; p.style.fontWeight = '600'; }
            if(radio) radio.checked = false;
        }
    });
    document.getElementById('campo-referencia').style.display =
        (metodo === 'qr' || metodo === 'transferencia') ? 'block' : 'none';
}

function calcularTotal() {
    let descuento = parseFloat(document.getElementById('input-descuento').value) || 0;
    const promoSelect = document.getElementById('select-promo');
    const selectedOption = promoSelect.options[promoSelect.selectedIndex];
    const promoValue = selectedOption ? parseFloat(selectedOption.dataset.valor) || 0 : 0;
    if(promoValue > 0) descuento = promoValue;
    const total = Math.max(0, precioBase - descuento);
    document.getElementById('total-display').textContent = 'Bs. ' + total.toLocaleString('es', {minimumFractionDigits:2});
}

function aplicarPromocion(promoId) {
    const select = document.getElementById('select-promo');
    const option = select.options[select.selectedIndex];
    const descuentoValor = parseFloat(option.dataset.valor) || 0;
    const msgDiv = document.getElementById('promo-msg');
    const descuentoInput = document.getElementById('input-descuento');
    if(descuentoValor > 0) {
        descuentoInput.value = descuentoValor;
        msgDiv.style.display = 'flex';
        msgDiv.style.alignItems = 'center';
        msgDiv.style.gap = '6px';
        msgDiv.style.background = '#E8F5E9';
        msgDiv.style.color = '#2E7D32';
        msgDiv.style.border = '1px solid #A5D6A7';
        msgDiv.innerHTML = '<i class="ti ti-tag" style="font-size:12px;"></i> Promoción aplicada: ' + option.text.split('—')[0] + ' — Descuento de Bs. ' + descuentoValor.toFixed(2);
    } else {
        msgDiv.style.display = 'none';
    }
    calcularTotal();
}
</script>
@endsection

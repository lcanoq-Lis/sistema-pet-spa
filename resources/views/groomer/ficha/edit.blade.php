@extends('layouts.dashboard')

@section('page-title', 'Ficha de Grooming')
@section('page-subtitle', 'Completa el checklist, registra fotos o insumos y cierra la sesión')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:600; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

    {{-- Encabezado --}}
    <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); border-radius:20px; padding:24px; margin-bottom:24px; color:#fff; position:relative; overflow:hidden;">
        <div style="position:absolute; right:-20px; top:-30px; width:140px; height:140px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
        <div style="position:absolute; right:30px; bottom:-40px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
        <div style="display:flex; gap:18px; align-items:center; position:relative;">
            <div style="width:60px; height:60px; background:rgba(255,255,255,0.12); border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:28px;">
                <i class="ti ti-dog"></i>
            </div>
            <div>
                <h3 style="font-size:18px; font-weight:800; margin:0;">{{ $ficha->cita->mascota->nombre }}</h3>
                <p style="opacity:0.9; font-size:12px; margin:2px 0 4px;">{{ $ficha->cita->servicio->nombre }}</p>
                <div style="opacity:0.85; font-size:11px; background:rgba(0,0,0,0.15); padding:4px 12px; border-radius:20px; margin-top:6px; display:inline-flex; align-items:center; gap:6px;">
                    <i class="ti ti-notes" style="font-size:11px;"></i>
                    <strong>Ingreso inicial:</strong> {{ $ficha->estado_inicial }}
                </div>
            </div>
        </div>
    </div>

{{-- PANEL DE REGISTRO FOTOGRÁFICO --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; margin-bottom:24px; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1565C0, #0D3B5E); padding:16px 20px; display:flex; align-items:center; gap:12px;">
        <i class="ti ti-camera" style="font-size:20px; color:#fff;"></i>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Galería de Evidencias</h3>
            <p style="font-size:11px; color:#BBDEFB; margin:0;">Fotos antes y después del servicio</p>
        </div>
        <div style="margin-left:auto; background:rgba(255,255,255,0.15); border-radius:20px; padding:4px 12px; display:flex; align-items:center; gap:4px;">
            <i class="ti ti-photo" style="font-size:12px;"></i>
            <span style="color:#fff; font-size:12px; font-weight:600;">{{ $ficha->fotos->count() }} foto(s)</span>
        </div>
    </div>

    <div style="padding:24px;">
        @if(!$ficha->fecha_cierre)
        {{-- Selectores --}}
        <div style="display:flex; gap:8px; margin-bottom:24px; background:#F5F5F0; border-radius:14px; padding:6px;">
            <button type="button" onclick="mostrarTab('tab-archivo')" id="btn-archivo"
                style="flex:1; padding:10px; border-radius:10px; border:none; background:#fff; color:#1B5E20; font-weight:700; font-size:12px; cursor:pointer; box-shadow:0 1px 3px rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:center; gap:6px;">
                <i class="ti ti-upload"></i> Subir archivo
            </button>
            <button type="button" onclick="mostrarTab('tab-camara')" id="btn-camara"
                style="flex:1; padding:10px; border-radius:10px; border:none; background:transparent; color:#5D6E5D; font-weight:600; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                <i class="ti ti-device-camera"></i> Cámara en vivo
            </button>
        </div>

        {{-- Subida archivo --}}
        <div id="tab-archivo">
            <div style="border:2px dashed #d0d5c8; border-radius:16px; padding:28px; background:#F9FBF6; text-align:center; cursor:pointer; transition:all 0.2s;"
                onclick="document.getElementById('input-archivo').click()"
                ondragover="event.preventDefault(); this.style.borderColor='#1B5E20'; this.style.background='#F0F5EC'"
                ondragleave="this.style.borderColor='#d0d5c8'; this.style.background='#F9FBF6'">
                <div>
                    <i class="ti ti-cloud-upload" style="font-size:36px; color:#8A9B8A; margin-bottom:8px; display:inline-block;"></i>
                    <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin:0 0 4px;">Arrastra una foto aquí</p>
                    <p style="font-size:11px; color:#8A9B8A;">o haz clic para seleccionar · JPG, PNG · máx. 5MB</p>
                </div>
                <input type="file" id="input-archivo" accept="image/*" style="display:none;" onchange="previsualizarArchivo(event)">
            </div>

            <div id="preview-archivo" style="display:none; margin-top:16px;">
                <div style="position:relative; display:inline-block; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                    <img id="img-preview-archivo" src="" alt="preview" style="max-height:180px; max-width:100%; display:block;">
                    <button type="button" onclick="limpiarPreviewArchivo()" style="position:absolute; top:6px; right:6px; background:rgba(0,0,0,0.6); color:#fff; border:none; border-radius:50%; width:24px; height:24px; font-size:12px; cursor:pointer;">✕</button>
                </div>
            </div>

            <div style="display:flex; gap:12px; align-items:center; margin-top:20px;">
                <div style="display:flex; gap:6px; flex:1; background:#F5F5F0; padding:4px; border-radius:12px;">
                    <button type="button" onclick="seleccionarTipoArchivo('antes')" id="tipo-archivo-antes" style="flex:1; padding:8px; border-radius:8px; border:none; background:#1B5E20; color:#fff; font-weight:700; font-size:11px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                        <i class="ti ti-camera"></i> Antes
                    </button>
                    <button type="button" onclick="seleccionarTipoArchivo('despues')" id="tipo-archivo-despues" style="flex:1; padding:8px; border-radius:8px; border:none; background:transparent; color:#5D6E5D; font-weight:600; font-size:11px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                        <i class="ti ti-checkbox"></i> Después
                    </button>
                </div>
                <input type="hidden" id="tipo-archivo-val" value="antes">
                <button type="button" onclick="subirFoto('archivo')" style="background:#1B5E20; border:none; border-radius:12px; padding:10px 20px; font-size:12px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-cloud-upload"></i> Subir Foto
                </button>
            </div>
        </div>

        {{-- Cámara --}}
        <div id="tab-camara" style="display:none;">
            <div style="border-radius:16px; overflow:hidden; background:#0F172A; text-align:center; min-height:140px; display:flex; align-items:center; justify-content:center; margin-bottom:14px;">
                <div id="camara-placeholder" style="color:#94A3B8; font-size:12px; padding:30px; text-align:center;">
                    <i class="ti ti-device-camera" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    Haz clic en "Activar cámara"
                </div>
                <video id="video-camara" autoplay playsinline style="display:none; width:100%; max-height:280px; object-fit:cover;"></video>
            </div>
            <canvas id="canvas-captura" style="display:none;"></canvas>

            <div id="preview-camara" style="display:none; text-align:center; margin-bottom:14px;">
                <div style="position:relative; display:inline-block; border-radius:12px; overflow:hidden;">
                    <img id="img-preview-camara" src="" alt="captura" style="max-height:200px; display:block;">
                </div>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <div style="display:flex; gap:6px; flex:1; background:#F5F5F0; padding:4px; border-radius:12px;">
                    <button type="button" onclick="seleccionarTipoCamara('antes')" id="tipo-camara-antes" style="flex:1; padding:8px; border-radius:8px; border:none; background:#1B5E20; color:#fff; font-weight:700; font-size:11px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                        <i class="ti ti-camera"></i> Antes
                    </button>
                    <button type="button" onclick="seleccionarTipoCamara('despues')" id="tipo-camara-despues" style="flex:1; padding:8px; border-radius:8px; border:none; background:transparent; color:#5D6E5D; font-weight:600; font-size:11px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                        <i class="ti ti-checkbox"></i> Después
                    </button>
                </div>
                <input type="hidden" id="tipo-camara-val" value="antes">

                <button type="button" onclick="iniciarCamara()" id="btn-iniciar-camara" style="background:#fff; border:1.5px solid #e0e0e0; border-radius:12px; padding:10px 16px; font-size:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-device-camera"></i> Activar
                </button>
                <button type="button" onclick="capturarFoto()" id="btn-capturar" style="display:none; background:#1B5E20; border:none; border-radius:12px; padding:10px 16px; font-size:12px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-camera"></i> Capturar
                </button>
                <button type="button" onclick="reiniciarCamara()" id="btn-reiniciar" style="display:none; background:#fff; border:1.5px solid #e0e0e0; border-radius:12px; padding:10px 16px; font-size:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-refresh"></i> Retomar
                </button>
                <button type="button" onclick="subirFoto('camara')" id="btn-subir-camara" style="display:none; background:#2E7D32; border:none; border-radius:12px; padding:10px 16px; font-size:12px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-cloud-upload"></i> Guardar
                </button>
            </div>
        </div>

        <div id="progreso-subida" style="display:none; margin-top:20px;">
            <div style="background:#F5F5F0; border-radius:8px; height:6px; overflow:hidden;">
                <div id="barra-progreso" style="height:100%; width:0%; background:#1B5E20; transition:width 0.3s;"></div>
            </div>
        </div>
        @endif

        {{-- Galería --}}
        @if($ficha->fotos && $ficha->fotos->count() > 0)
        <div style="margin-top:28px; border-top:1px solid #e0e0e0; padding-top:20px;">
            <div style="display:flex; gap:8px; margin-bottom:16px;">
                <button type="button" onclick="filtrarFotos('todas')" id="filtro-todas" style="padding:6px 16px; border-radius:20px; border:none; background:#1B5E20; color:#fff; font-size:11px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-photo"></i> Todas
                </button>
                <button type="button" onclick="filtrarFotos('antes')" id="filtro-antes" style="padding:6px 16px; border-radius:20px; border:1px solid #e0e0e0; background:#fff; color:#5D6E5D; font-size:11px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-camera"></i> Antes
                </button>
                <button type="button" onclick="filtrarFotos('despues')" id="filtro-despues" style="padding:6px 16px; border-radius:20px; border:1px solid #e0e0e0; background:#fff; color:#5D6E5D; font-size:11px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-checkbox"></i> Después
                </button>
            </div>

            <div id="galeria-fotos" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px,1fr)); gap:12px;">
                @foreach($ficha->fotos as $foto)
                <div class="foto-item" data-tipo="{{ $foto->tipo }}" style="position:relative; border-radius:12px; overflow:hidden; aspect-ratio:1/1; border:1px solid #e0e0e0;">
                    <img src="{{ asset('storage/' . $foto->url) }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="abrirModalFoto(this.src)">
                    <span style="position:absolute; bottom:6px; left:8px; background:rgba(0,0,0,0.6); color:#fff; font-size:9px; font-weight:700; padding:3px 8px; border-radius:6px; display:flex; align-items:center; gap:4px;">
                        <i class="ti {{ $foto->tipo === 'antes' ? 'ti-camera' : 'ti-checkbox' }}" style="font-size:9px;"></i> {{ $foto->tipo }}
                    </span>
                    @if(!$ficha->fecha_cierre)
                    <form method="POST" action="{{ route('groomer.ficha.foto.eliminar', $foto->id) }}" style="position:absolute; top:6px; right:6px;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar esta foto?')" style="background:#C62828; border:none; border-radius:50%; width:22px; height:22px; color:#fff; font-size:10px; cursor:pointer;">✕</button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- FORMULARIO PRINCIPAL CHECKLIST --}}
<form method="POST" action="{{ route('groomer.ficha.update', $ficha->id) }}">
    @csrf @method('PUT')
    
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; margin-bottom:24px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
            <i class="ti ti-checklist" style="color:#1B5E20; font-size:18px;"></i>
            <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">Checklist del servicio</h3>
        </div>

        @foreach($ficha->checklist as $check)
        <div style="display:flex; align-items:start; gap:14px; padding:14px 0; border-bottom:1px solid #e0e0e0; cursor:pointer;" onclick="toggleCheck({{ $check->item_id }})">
            <div id="box-{{ $check->item_id }}" style="width:22px; height:22px; border-radius:8px; border:2px solid #BDBDBD; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.2s; {{ $check->completado ? 'background:#1B5E20; border-color:#1B5E20;' : 'background:#fff;' }}">
                @if($check->completado) <i class="ti ti-check" style="color:#fff; font-size:12px;"></i> @endif
            </div>

            <input type="checkbox" name="checklist[{{ $check->item_id }}][completado]" id="check-{{ $check->item_id }}" {{ $check->completado ? 'checked' : '' }} style="display:none;">

            <div style="flex:1;">
                <label style="font-size:13px; font-weight:600; color:#1A2E1A; cursor:pointer; {{ $check->completado ? 'text-decoration:line-through; opacity:0.6;' : '' }}" id="label-{{ $check->item_id }}">
                    {{ $check->item->nombre }}
                </label>
                <input type="text" name="checklist[{{ $check->item_id }}][observacion]" value="{{ $check->observacion }}" placeholder="Añadir observación..." onclick="event.stopPropagation()" style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 12px; font-size:12px; margin-top:8px; outline:none; background:#FAFBF7;" onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>
        @endforeach
    </div>

    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; margin-bottom:24px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
            <i class="ti ti-notes" style="color:#1B5E20; font-size:18px;"></i>
            <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">Diagnóstico final</h3>
        </div>
        
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; text-transform:uppercase; margin-bottom:6px;">
                <i class="ti ti-logout"></i> Estado final al egreso
            </label>
            <textarea name="estado_final" rows="3" style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px; font-size:13px; outline:none; background:#FAFBF7;" onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">{{ $ficha->estado_final }}</textarea>
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; text-transform:uppercase; margin-bottom:6px;">
                <i class="ti ti-lock"></i> Notas internas reservadas
            </label>
            <textarea name="notes_internas" rows="2" style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px; font-size:13px; outline:none; background:#FAFBF7;" onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">{{ $ficha->notas_internas }}</textarea>
        </div>
    </div>

    @if(!$ficha->fecha_cierre)
    <button type="submit" style="width:100%; background:#fff; border:1.5px solid #1B5E20; border-radius:14px; padding:12px; font-size:13px; font-weight:700; color:#1B5E20; cursor:pointer; margin-bottom:24px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
        <i class="ti ti-device-floppy"></i> Guardar cambios de progreso
    </button>
    @endif
</form>

{{-- INSUMOS --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; margin-bottom:24px; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #2E7D32, #1B5E20); padding:16px 20px; display:flex; align-items:center; gap:12px;">
        <i class="ti ti-package" style="font-size:20px; color:#fff;"></i>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Insumos utilizados</h3>
            <p style="font-size:11px; color:#C8E6C9; margin:0;">Control de existencias y productos consumidos</p>
        </div>
    </div>

    <div style="padding:24px;">
        @if(!$ficha->fecha_cierre)
        <form method="POST" action="{{ route('groomer.ficha.insumo.store', $ficha->id) }}" style="background:#F9FBF6; border-radius:16px; padding:20px; margin-bottom:24px; border:1px solid #E0E5D9;">
            @csrf
            <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:#4A7A4A;">Producto</label>
                    <select name="producto_id" required style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:9px; font-size:12px; background:#fff;">
                        <option value="">— Seleccionar —</option>
                        @foreach($productos as $p)
                            <option value="{{ $p->id }}" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                {{ $p->nombre }} (Stock: {{ $p->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:#4A7A4A;">Cantidad</label>
                    <input type="number" name="cantidad" min="0.1" step="0.1" value="1" required style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:9px; font-size:12px;">
                </div>
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:#4A7A4A;">Unidad</label>
                    <select name="unidad" style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:9px; font-size:12px; background:#fff;">
                        <option value="unidad">Unidad</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="aplicacion">Aplicación</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:#4A7A4A;">Estado</label>
                    <select name="estado" style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:9px; font-size:12px; background:#fff;">
                        <option value="usado">Usado</option>
                        <option value="devuelto">Devuelto</option>
                        <option value="desperdiciado">Desperdiciado</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <input type="text" name="observacion" placeholder="Observaciones del uso de producto..." style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:9px; font-size:12px;">
            </div>

            <button type="submit" style="background:#1B5E20; border:none; border-radius:12px; padding:8px 18px; font-size:12px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; gap:6px;">
                <i class="ti ti-plus"></i> Añadir Producto
            </button>
        </form>
        @endif

        <div style="display:flex; flex-direction:column; gap:8px;">
            @foreach($ficha->insumos as $insumo)
            <div style="display:flex; align-items:center; justify-content:space-between; background:#F9FBF6; border:1px solid #E0E5D9; padding:12px 16px; border-radius:12px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="ti ti-package" style="color:#2E7D32; font-size:16px;"></i>
                    <div>
                        <p style="font-size:13px; font-weight:700; margin:0;">{{ $insumo->producto->nombre }}</p>
                        <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0;">{{ $insumo->cantidad }} {{ $insumo->unidad }} · Estado: {{ $insumo->estado }}</p>
                    </div>
                </div>
                @if(!$ficha->fecha_cierre)
                <form method="POST" action="{{ route('groomer.ficha.insumo.destroy', [$ficha->id, $insumo->id]) }}">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Retirar este insumo?')" style="background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2; padding:4px 10px; border-radius:8px; font-size:11px; cursor:pointer; display:flex; align-items:center; gap:4px;">
                        <i class="ti ti-trash"></i>
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CIERRE --}}
@if(!$ficha->fecha_cierre)
<form method="POST" action="{{ route('groomer.ficha.cerrar', $ficha->id) }}">
    @csrf
    <button type="submit" onclick="return confirm('¿Confirmas el cierre completo del servicio?')" style="width:100%; background:linear-gradient(135deg, #1B5E20, #0D3B0D); border:none; border-radius:16px; padding:14px; font-size:14px; font-weight:700; color:#fff; cursor:pointer; box-shadow:0 4px 12px rgba(27,94,32,0.2); display:flex; align-items:center; justify-content:center; gap:8px;">
        <i class="ti ti-circle-check"></i> Finalizar Servicio y Notificar Retiro
    </button>
</form>
@else
<div style="background:#F5F5F0; border-radius:12px; padding:14px; text-align:center; margin-bottom:24px; display:flex; align-items:center; justify-content:center; gap:8px;">
    <i class="ti ti-lock" style="color:#5D6E5D;"></i>
    <span style="color:#5D6E5D; font-weight:700; font-size:13px;">Sesión de Historial Completada y Bloqueada</span>
</div>
@endif

</div>

{{-- MODAL --}}
<div id="modal-foto" onclick="cerrarModalFoto()" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.8); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="position:relative; max-width:85vw; max-height:85vh;">
        <img id="modal-img" src="" style="max-width:85vw; max-height:85vh; border-radius:16px; object-fit:contain;">
        <button onclick="cerrarModalFoto()" style="position:absolute; top:-12px; right:-12px; background:#fff; border:none; border-radius:50%; width:32px; height:32px; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
            <i class="ti ti-x"></i>
        </button>
    </div>
</div>

<script>
const CSRF     = '{{ csrf_token() }}';
const FOTO_URL = '{{ route("groomer.ficha.foto", $ficha->id) }}';
let streamCamara  = null;
let blobCapturado = null;
let tipoArchivo   = 'antes';
let tipoCamara    = 'antes';

function mostrarTab(tab) {
    const esArchivo = tab === 'tab-archivo';
    document.getElementById('tab-archivo').style.display = esArchivo ? 'block' : 'none';
    document.getElementById('tab-camara').style.display  = esArchivo ? 'none'  : 'block';
    document.getElementById('btn-archivo').style.background = esArchivo ? '#fff' : 'transparent';
    document.getElementById('btn-camara').style.background  = !esArchivo ? '#fff' : 'transparent';
    if(esArchivo) detenerCamara();
}

function seleccionarTipoArchivo(val) { tipoArchivo = val; document.getElementById('tipo-archivo-val').value = val; }
function seleccionarTipoCamara(val) { tipoCamara = val; document.getElementById('tipo-camara-val').value = val; }

function previsualizarArchivo(e) {
    const file = e.target.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('img-preview-archivo').src = ev.target.result;
            document.getElementById('preview-archivo').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
function limpiarPreviewArchivo() {
    document.getElementById('input-archivo').value = '';
    document.getElementById('preview-archivo').style.display = 'none';
}

async function iniciarCamara() {
    try {
        streamCamara = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
        document.getElementById('video-camara').srcObject = streamCamara;
        document.getElementById('video-camara').style.display = 'block';
        document.getElementById('camara-placeholder').style.display = 'none';
        document.getElementById('btn-capturar').style.display = 'inline-flex';
        document.getElementById('btn-iniciar-camara').style.display = 'none';
    } catch (err) {
        alert('Cámara no disponible.');
    }
}
function detenerCamara() {
    if (streamCamara) streamCamara.getTracks().forEach(t => t.stop());
}
function capturarFoto() {
    const video = document.getElementById('video-camara');
    const canvas = document.getElementById('canvas-captura');
    canvas.width = video.videoWidth; canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    canvas.toBlob(blob => {
        blobCapturado = blob;
        document.getElementById('img-preview-camara').src = URL.createObjectURL(blob);
        document.getElementById('preview-camara').style.display = 'block';
        document.getElementById('btn-subir-camara').style.display = 'inline-flex';
    }, 'image/jpeg');
}

function subirFoto(fuente) {
    const formData = new FormData();
    formData.append('_token', CSRF);
    if (fuente === 'archivo') {
        const fileInput = document.getElementById('input-archivo');
        if(!fileInput.files[0]) return;
        formData.append('foto', fileInput.files[0]);
        formData.append('tipo', tipoArchivo);
    } else {
        if(!blobCapturado) return;
        formData.append('foto', blobCapturado, 'captura.jpg');
        formData.append('tipo', tipoCamara);
    }

    document.getElementById('progreso-subida').style.display = 'block';
    fetch(FOTO_URL, { method: 'POST', body: formData })
        .then(() => location.reload())
        .catch(() => alert('Error de sincronización.'));
}

function toggleCheck(itemId) {
    const checkbox = document.getElementById('check-' + itemId);
    const box      = document.getElementById('box-' + itemId);
    const label    = document.getElementById('label-' + itemId);
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        box.style.background = '#1B5E20';
        box.innerHTML = '<i class="ti ti-check" style="color:#fff; font-size:12px;"></i>';
        label.style.textDecoration = 'line-through';
        label.style.opacity = '0.6';
    } else {
        box.style.background = '#fff'; box.innerHTML = '';
        label.style.textDecoration = 'none'; label.style.opacity = '1';
    }
}

function abrirModalFoto(src) {
    document.getElementById('modal-img').src = src;
    document.getElementById('modal-foto').style.display = 'flex';
}
function cerrarModalFoto() {
    document.getElementById('modal-foto').style.display = 'none';
}
</script>
@endsection
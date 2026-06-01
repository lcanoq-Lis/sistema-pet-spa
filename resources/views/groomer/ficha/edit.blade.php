@extends('layouts.dashboard')

@section('page-title', '📋 Ficha de Grooming')
@section('page-subtitle', 'Completa el checklist, registra fotos o insumos y cierra la sesión')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">

@if(session('status'))
    <div class="alert alert-success" style="margin-bottom: 16px;">
        ✅ {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 16px;">
        ⚠️ {{ $errors->first() }}
    </div>
@endif

    {{-- Encabezado con información de la Mascota y el Servicio --}}
    <div class="stat-card" style="background: linear-gradient(135deg, var(--brand), #0f766e); color: white; margin-bottom: 20px; padding: 20px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; gap: 18px; align-items: center;">
            <div style="font-size: 40px; width: 60px; height: 60px; background: rgba(255,255,255,0.15); display: grid; place-items: center; border-radius: var(--radius-md); backdrop-filter: blur(4px);">
                @if($ficha->cita->mascota->especie === 'perro') 🐶
                @elseif($ficha->cita->mascota->especie === 'gato') 🐱
                @else 🐾
                @endif
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0;">{{ $ficha->cita->mascota->nombre }}</h3>
                <p style="opacity: 0.9; margin: 2px 0 4px; font-size: 13px; font-weight: 500;">{{ $ficha->cita->servicio->nombre }}</p>
                <p style="opacity: 0.85; font-size: 12px; background: rgba(0,0,0,0.12); padding: 4px 8px; border-radius: 6px; margin: 0;">
                    <strong>Ingreso inicial:</strong> {{ $ficha->estado_inicial }}
                </p>
            </div>
        </div>
    </div>

{{-- PANEL DE REGISTRO FOTOGRÁFICO (EVIDENCIAS) --}}
<div class="stat-card" style="margin-bottom: 20px; background: var(--surface); border-radius: var(--radius-lg); overflow: hidden; padding: 0;">
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 16px 20px; display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 20px;">📸</span>
        <div>
            <h3 style="font-size: 15px; font-weight: 700; color: white; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;">Galería de Evidencias</h3>
            <p style="font-size: 11px; color: #94a3b8; margin: 0;">Fotos antes y después del servicio clínico/estético</p>
        </div>
        <div style="margin-left: auto; background: rgba(255,255,255,0.1); border-radius: 20px; padding: 4px 12px; border: 1px solid rgba(255,255,255,0.1);">
            <span style="color: white; font-size: 12px; font-weight: 600;">{{ $ficha->fotos->count() }} foto(s)</span>
        </div>
    </div>

    <div style="padding: 20px;">
        @if(!$ficha->fecha_cierre)
        {{-- Selectores de origen de foto (Archivo vs Cámara en vivo) --}}
        <div style="display: flex; gap: 6px; margin-bottom: 20px; background: var(--bg); border-radius: var(--radius-md); padding: 4px; border: 1px solid var(--border);">
            <button type="button" onclick="mostrarTab('tab-archivo')" id="btn-archivo"
                style="flex: 1; padding: 9px 12px; border-radius: 6px; border: none; background: white; color: var(--brand); font-weight: 700; font-size: 13px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: var(--shadow-sm); transition: all 0.2s;">
                📁 Subir archivo
            </button>
            <button type="button" onclick="mostrarTab('tab-camara')" id="btn-camara"
                style="flex: 1; padding: 9px 12px; border-radius: 6px; border: none; background: transparent; color: var(--text-secondary); font-weight: 600; font-size: 13px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.2s;">
                📷 Cámara en vivo
            </button>
        </div>

        {{-- Contenedor de Subida Tradicional --}}
        <div id="tab-archivo">
            <div style="border: 2px dashed var(--border); border-radius: var(--radius-lg); padding: 24px; background: var(--bg); text-align: center; cursor: pointer; transition: all 0.2s;"
                onclick="document.getElementById('input-archivo').click()"
                ondragover="event.preventDefault(); this.style.borderColor='var(--brand)';"
                ondragleave="this.style.borderColor='var(--border)';">
                <div id="zona-drop-contenido">
                    <div style="font-size: 32px; margin-bottom: 8px;">🖼️</div>
                    <p style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px;">Arrastra una foto aquí</p>
                    <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">o haz clic para seleccionar · JPG, PNG · máx. 5MB</p>
                </div>
                <input type="file" id="input-archivo" accept="image/*" style="display: none;" onchange="previsualizarArchivo(event)">
            </div>

            <div id="preview-archivo" style="display: none; margin-top: 16px;">
                <div style="position: relative; display: inline-block; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-md);">
                    <img id="img-preview-archivo" src="" alt="preview" style="max-height: 180px; max-width: 100%; display: block; border-radius: var(--radius-md);">
                    <button type="button" onclick="limpiarPreviewArchivo()" style="position: absolute; top: 6px; right: 6px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; font-size: 12px; cursor: pointer;">✕</button>
                </div>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; margin-top: 16px;">
                <div style="display: flex; gap: 6px; flex: 1; background: var(--bg); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border);">
                    <button type="button" onclick="seleccionarTipoArchivo('antes')" id="tipo-archivo-antes" style="flex: 1; padding: 8px; border-radius: 6px; border: none; background: var(--brand); color: white; font-weight: 700; font-size: 12px; cursor: pointer;">📷 Antes</button>
                    <button type="button" onclick="seleccionarTipoArchivo('despues')" id="tipo-archivo-despues" style="flex: 1; padding: 8px; border-radius: 6px; border: none; background: transparent; color: var(--text-secondary); font-weight: 600; font-size: 12px; cursor: pointer;">✅ Después</button>
                </div>
                <input type="hidden" id="tipo-archivo-val" value="antes">
                <button type="button" onclick="subirFoto('archivo')" class="btn btn-primary" style="padding: 10px 24px; font-size: 13px;">📤 Subir Foto</button>
            </div>
        </div>

        {{-- Contenedor de Captura por Cámara Directa --}}
        <div id="tab-camara" style="display: none;">
            <div style="border-radius: var(--radius-md); overflow: hidden; background: #0f172a; text-align: center; min-height: 140px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; border: 1px solid var(--border);">
                <div id="camara-placeholder" style="color: #64748b; font-size: 13px; padding: 30px;">
                    <div style="font-size: 28px; margin-bottom: 6px;">🎥</div>
                    Haz clic en "Activar cámara" para iniciar la captura
                </div>
                <video id="video-camara" autoplay playsinline style="display: none; width: 100%; max-height: 280px; object-fit: cover;"></video>
            </div>
            <canvas id="canvas-captura" style="display: none;"></canvas>

            <div id="preview-camara" style="display: none; text-align: center; margin-bottom: 14px;">
                <div style="position: relative; display: inline-block; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-md);">
                    <img id="img-preview-camara" src="" alt="captura" style="max-height: 200px; display: block; border-radius: var(--radius-md);">
                </div>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <div style="display: flex; gap: 6px; flex: 1; background: var(--bg); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border);">
                    <button type="button" onclick="seleccionarTipoCamara('antes')" id="tipo-camara-antes" style="flex: 1; padding: 8px; border-radius: 6px; border: none; background: var(--brand); color: white; font-weight: 700; font-size: 12px; cursor: pointer;">📷 Antes</button>
                    <button type="button" onclick="seleccionarTipoCamara('despues')" id="tipo-camara-despues" style="flex: 1; padding: 8px; border-radius: 6px; border: none; background: transparent; color: var(--text-secondary); font-weight: 600; font-size: 12px; cursor: pointer;">✅ Después</button>
                </div>
                <input type="hidden" id="tipo-camara-val" value="antes">

                <button type="button" onclick="iniciarCamara()" id="btn-iniciar-camara" class="btn btn-secondary" style="padding: 10px 16px; font-size: 13px;">🎥 Activar Cámara</button>
                <button type="button" onclick="capturarFoto()" id="btn-capturar" class="btn btn-primary" style="display: none; padding: 10px 16px; font-size: 13px;">📸 Capturar</button>
                <button type="button" onclick="reiniciarCamara()" id="btn-reiniciar" class="btn btn-secondary" style="display: none; padding: 10px 16px; font-size: 13px;">🔄 Retomar</button>
                <button type="button" onclick="subirFoto('camara')" id="btn-subir-camara" class="btn" style="display: none; padding: 10px 16px; font-size: 13px; background: #16a34a; color: white;">📤 Guardar</button>
            </div>
        </div>

        <div id="progreso-subida" style="display: none; margin-top: 16px;">
            <div style="background: var(--bg); border-radius: 8px; height: 6px; overflow: hidden; border: 1px solid var(--border);">
                <div id="barra-progreso" style="height: 100%; width: 0%; background: var(--brand); transition: width 0.3s ease;"></div>
            </div>
        </div>
        <div id="mensaje-subida" style="display: none; margin-top: 14px; padding: 10px 14px; border-radius: var(--radius-md); font-size: 13px; font-weight: 500;"></div>
        @endif

        {{-- Despliegue de fotos de la Ficha --}}
        @if($ficha->fotos && $ficha->fotos->count() > 0)
        <div style="margin-top: 24px; border-top: 1px solid var(--border); padding-top: 16px;">
            <div style="display: flex; gap: 6px; margin-bottom: 14px;">
                <button type="button" onclick="filtrarFotos('todas')" id="filtro-todas" style="padding: 6px 14px; border-radius: 20px; border: none; background: var(--brand); color: white; font-size: 12px; font-weight: 700; cursor: pointer;">Todas</button>
                <button type="button" onclick="filtrarFotos('antes')" id="filtro-antes" style="padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border); background: transparent; color: var(--text-secondary); font-size: 12px; font-weight: 600; cursor: pointer;">Antes</button>
                <button type="button" onclick="filtrarFotos('despues')" id="filtro-despues" style="padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border); background: transparent; color: var(--text-secondary); font-size: 12px; font-weight: 600; cursor: pointer;">Después</button>
            </div>

            <div id="galeria-fotos" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px;">
                @foreach($ficha->fotos as $foto)
                <div class="foto-item" data-tipo="{{ $foto->tipo }}" style="position: relative; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 1/1; border: 1px solid var(--border);">
                    <img src="{{ asset('storage/' . $foto->url) }}" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="abrirModalFoto(this.src)">
                    <span style="position: absolute; bottom: 6px; left: 8px; color: white; font-size: 10px; font-weight: 700; text-transform: uppercase; background: rgba(0,0,0,0.5); padding: 2px 6px; border-radius: 4px;">
                        {{ $foto->tipo === 'antes' ? '📷' : '✅' }} {{ $foto->tipo }}
                    </span>
                    @if(!$ficha->fecha_cierre)
                    <form method="POST" action="{{ route('groomer.ficha.foto.eliminar', $foto->id) }}" style="position: absolute; top: 6px; right: 6px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar esta foto?')" style="width: 22px; height: 22px; border-radius: 50%; background: rgba(220,38,38,0.85); color: white; border: none; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- FORMULARIO PRINCIPAL DE GESTIÓN (CHECKLIST Y DIAGNÓSTICO) --}}
<form method="POST" action="{{ route('groomer.ficha.update', $ficha->id) }}">
    @csrf
    @method('PUT')
    
    <div class="stat-card" style="margin-bottom: 20px; padding: 24px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif;">✅ Checklist del servicio</h3>

        @foreach($ficha->checklist as $check)
        <div style="display: flex; align-items: start; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--border); cursor: pointer;" onclick="toggleCheck({{ $check->item_id }})">
            
            <div id="box-{{ $check->item_id }}" style="width: 22px; height: 22px; border-radius: 6px; border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.2s; {{ $check->completado ? 'background: var(--brand); border-color: var(--brand);' : 'background: #fff;' }}">
                @if($check->completado) <span style="color: white; font-size: 13px; font-weight: bold;">✓</span> @endif
            </div>

            <input type="checkbox" name="checklist[{{ $check->item_id }}][completado]" id="check-{{ $check->item_id }}" {{ $check->completado ? 'checked' : '' }} style="display: none;">

            <div style="flex: 1;">
                <label style="font-size: 14px; font-weight: 600; color: var(--text-primary); cursor: pointer; {{ $check->completado ? 'text-decoration: line-through; color: var(--text-secondary); opacity: 0.7;' : '' }}" id="label-{{ $check->item_id }}">
                    {{ $check->item->nombre }}
                </label>
                
                {{-- Campo opcional u obligatorio si aplica --}}
                <input type="text" name="checklist[{{ $check->item_id }}][observacion]" value="{{ $check->observacion }}" placeholder="Añadir observación..." onclick="event.stopPropagation()" style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 8px 12px; font-size: 13px; outline: none; margin-top: 8px; box-sizing: border-box;">
            </div>
        </div>
        @endforeach
    </div>

    <div class="stat-card" style="margin-bottom: 20px; padding: 24px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif;">📝 Diagnóstico final</h3>
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; text-transform: uppercase;">Estado final al egreso</label>
            <textarea name="estado_final" rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 12px; font-size: 14px; outline: none; box-sizing: border-box;">{{ $ficha->estado_final }}</textarea>
        </div>

        <div>
            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; text-transform: uppercase;">Notas internas reservadas</label>
            <textarea name="notes_internas" rows="2" style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 12px; font-size: 14px; outline: none; box-sizing: border-box;">{{ $ficha->notas_internas }}</textarea>
        </div>
    </div>

    @if(!$ficha->fecha_cierre)
    <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 12px; font-size: 14px; font-weight: 700; margin-bottom: 20px; justify-content: center; background: white; border: 1.5px solid var(--brand); color: var(--brand);">
        💾 Guardar cambios de progreso
    </button>
    @endif
</form>

{{-- SECCIÓN ELEGANTE DE CONSUMO DE INSUMOS --}}
<div class="stat-card" style="margin-bottom: 20px; background: var(--surface); border-radius: var(--radius-lg); overflow: hidden; padding: 0;">
    <div style="background: linear-gradient(135deg, #047857, #065f46); padding: 16px 20px; display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 20px;">🧴</span>
        <div>
            <h3 style="font-size: 15px; font-weight: 700; color: white; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;">Insumos utilizados</h3>
            <p style="font-size: 11px; color: #a7f3d0; margin: 0;">Control de existencias y productos consumidos</p>
        </div>
    </div>

    <div style="padding: 20px;">
        @if(!$ficha->fecha_cierre)
        <form method="POST" action="{{ route('groomer.ficha.insumo.store', $ficha->id) }}" style="background: var(--bg); border-radius: var(--radius-md); padding: 16px; margin-bottom: 20px; border: 1px solid var(--border);">
            @csrf
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700;">Producto</label>
                    <select name="producto_id" required style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 9px; font-size: 13px; background: white;">
                        <option value="">— Seleccionar —</option>
                        @foreach($productos as $p)
                            <option value="{{ $p->id }}" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                {{ $p->nombre }} (Stock: {{ $p->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700;">Cantidad</label>
                    <input type="number" name="submit_cantidad" name="cantidad" min="0.1" step="0.1" value="1" required style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 9px; font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700;">Unidad</label>
                    <select name="unidad" style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 9px; font-size: 13px; background: white;">
                        <option value="unidad">Unidad</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="aplicacion">Aplicación</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700;">Estado</label>
                    <select name="estado" style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 9px; font-size: 13px; background: white;">
                        <option value="usado">Usado</option>
                        <option value="devuelto">Devuelto</option>
                        <option value="desperdiciado">Desperdiciado</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <input type="text" name="observacion" placeholder="Observaciones del uso de producto..." style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 9px; font-size: 13px;">
            </div>

            <button type="submit" class="btn btn-primary" style="font-size: 13px; padding: 8px 18px;">💾 Añadir Producto</button>
        </form>
        @endif

        <div style="display: flex; flex-direction: column; gap: 8px;">
            @foreach($ficha->insumos as $insumo)
            <div style="display: flex; align-items: center; justify-content: space-between; background: var(--bg); border: 1px solid var(--border); padding: 10px 14px; border-radius: var(--radius-md);">
                <div>
                    <p style="font-size: 13px; font-weight: 700; margin: 0;">{{ $insumo->producto->nombre }}</p>
                    <p style="font-size: 11px; color: var(--text-secondary); margin: 2px 0 0;">{{ $insumo->cantidad }} {{ $insumo->unidad }} · Estado: {{ $insumo->estado }}</p>
                </div>
                
                @if(!$ficha->fecha_cierre)
                <form method="POST" action="{{ route('groomer.ficha.insumo.destroy', [$ficha->id, $insumo->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Retirar este insumo?')" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 4px 10px; border-radius: 6px; font-size: 12px; cursor: pointer;">✕</button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ACCIÓN FINAL: COMPLEMENTAR Y CERRAR --}}
@if(!$ficha->fecha_cierre)
<form method="POST" action="{{ route('groomer.ficha.cerrar', $ficha->id) }}">
    @csrf
    <button type="submit" onclick="return confirm('¿Confirmas el cierre completo del servicio? Se despachará una alerta al cliente.')" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 15px; font-weight: 700; background: linear-gradient(135deg, #16a34a, #15803d); box-shadow: 0 4px 12px rgba(22,163,74,0.2);">
        🎉 Finalizar Servicio y Notificar Retiro
    </button>
</form>
@else
<div style="background: #e2e8f0; color: #475569; border-radius: var(--radius-md); padding: 14px; text-align: center; font-weight: 700; font-size: 14px; margin-bottom: 24px;">
    🔒 Sesión de Historial Completada y Bloqueada
</div>
@endif

</div>

{{-- MODAL INTERACTIVO DE FOTOS --}}
<div id="modal-foto" onclick="cerrarModalFoto()" style="display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.8); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="position: relative; max-width: 85vw; max-height: 85vh;">
        <img id="modal-img" src="" style="max-width: 85vw; max-height: 85vh; border-radius: var(--radius-md); object-fit: contain;">
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
    document.getElementById('btn-archivo').style.background = esArchivo ? 'white' : 'transparent';
    document.getElementById('btn-camara').style.background  = !esArchivo ? 'white' : 'transparent';
    if(esArchivo) detenerCamara();
}

function seleccionarTipoArchivo(val) {
    tipoArchivo = val; document.getElementById('tipo-archivo-val').value = val;
}
function seleccionarTipoCamara(val) {
    tipoCamara = val; document.getElementById('tipo-camara-val').value = val;
}

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
        document.getElementById('btn-capturar').style.display = 'inline-block';
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
        document.getElementById('btn-subir-camara').style.display = 'inline-block';
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
        box.style.background = 'var(--brand)';
        box.innerHTML = '<span style="color:white; font-size:13px; font-weight:bold;">✓</span>';
        label.style.textDecoration = 'line-through';
        label.style.opacity = '0.6';
    } else {
        box.style.background = 'white'; box.innerHTML = '';
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
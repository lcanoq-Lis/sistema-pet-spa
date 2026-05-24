@extends('layouts.dashboard')

@section('page-title', '📋 Ficha de Grooming')
@section('page-subtitle', 'Completa el checklist y cierra la ficha')

@section('content')
<div style="max-width:700px; margin:0 auto;">

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ⚠️ {{ $errors->first() }}
    </div>
@endif

    {{-- Info mascota --}}
    <div class="stat-card" style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; margin-bottom:16px;">
        <div style="display:flex; gap:16px; align-items:center;">
            <div style="font-size:48px;">
                @if($ficha->cita->mascota->especie === 'perro') 🐶
                @elseif($ficha->cita->mascota->especie === 'gato') 🐱
                @else 🐾
                @endif
            </div>
            <div>
                <h3 style="font-size:18px; font-weight:800;">{{ $ficha->cita->mascota->nombre }}</h3>
                <p style="opacity:0.9;">{{ $ficha->cita->servicio->nombre }}</p>
                <p style="opacity:0.8; font-size:13px;">Estado ingreso: {{ $ficha->estado_inicial }}</p>
            </div>
        </div>
    </div>

{{-- TARJETA DE EVIDENCIAS FOTOGRÁFICAS --}}
<div class="stat-card" style="margin-bottom:16px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.06);">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">📸</span>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Galería de Evidencias</h3>
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Fotos antes y después del servicio</p>
        </div>
        <div style="margin-left:auto; background:rgba(255,255,255,0.2); border-radius:20px; padding:4px 12px;">
            <span style="color:white; font-size:12px; font-weight:600;">{{ $ficha->fotos->count() }} foto{{ $ficha->fotos->count() !== 1 ? 's' : '' }}</span>
        </div>
    </div>

    <div style="padding:20px;">

        @if(!$ficha->fecha_cierre)
        {{-- TABS --}}
        <div style="display:flex; gap:8px; margin-bottom:20px; background:#f5f0eb; border-radius:12px; padding:4px;">
            <button type="button" onclick="mostrarTab('tab-archivo')" id="btn-archivo"
                style="flex:1; padding:9px 12px; border-radius:9px; border:none; background:white; color:#ff7043; font-weight:700; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif; box-shadow:0 1px 4px rgba(0,0,0,0.1); transition:all 0.2s;">
                📁 Subir archivo
            </button>
            <button type="button" onclick="mostrarTab('tab-camara')" id="btn-camara"
                style="flex:1; padding:9px 12px; border-radius:9px; border:none; background:transparent; color:#a1887f; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif; transition:all 0.2s;">
                📷 Cámara en vivo
            </button>
        </div>

        {{-- TAB 1: Subir archivo --}}
        <div id="tab-archivo">
            <div style="border:2px dashed #ffd0b5; border-radius:14px; padding:20px; background:#fff8f5; text-align:center; cursor:pointer; transition:all 0.2s;"
                onclick="document.getElementById('input-archivo').click()"
                ondragover="event.preventDefault(); this.style.borderColor='#ff7043'; this.style.background='#fff0e8';"
                ondragleave="this.style.borderColor='#ffd0b5'; this.style.background='#fff8f5';"
                ondrop="soltarArchivo(event)">
                <div id="zona-drop-contenido">
                    <div style="font-size:36px; margin-bottom:8px;">🖼️</div>
                    <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0 0 4px;">Arrastra una foto aquí</p>
                    <p style="font-size:12px; color:#a1887f; margin:0;">o haz clic para seleccionar · JPG, PNG, WEBP · máx. 5MB</p>
                </div>
                <input type="file" id="input-archivo" accept="image/*" style="display:none;" onchange="previsualizarArchivo(event)">
            </div>

            {{-- Vista previa --}}
            <div id="preview-archivo" style="display:none; margin-top:16px;">
                <div style="position:relative; display:inline-block; border-radius:12px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.12);">
                    <img id="img-preview-archivo" src="" alt="preview"
                        style="max-height:180px; max-width:100%; display:block; border-radius:12px;">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.5), transparent); border-radius:12px;"></div>
                    <span style="position:absolute; bottom:8px; left:10px; color:white; font-size:12px; font-weight:600;">Vista previa</span>
                    <button type="button" onclick="limpiarPreviewArchivo()"
                        style="position:absolute; top:6px; right:6px; background:rgba(0,0,0,0.5); color:white; border:none; border-radius:50%; width:24px; height:24px; font-size:13px; cursor:pointer; line-height:1;">✕</button>
                </div>
            </div>

            {{-- Tipo + Botón subir --}}
            <div style="display:flex; gap:10px; align-items:center; margin-top:14px;">
                <div style="display:flex; gap:6px; flex:1;">
                    <button type="button" onclick="seleccionarTipoArchivo('antes')" id="tipo-archivo-antes"
                        style="flex:1; padding:9px; border-radius:10px; border:2px solid #ff7043; background:#ff7043; color:white; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif;">
                        📷 Antes
                    </button>
                    <button type="button" onclick="seleccionarTipoArchivo('despues')" id="tipo-archivo-despues"
                        style="flex:1; padding:9px; border-radius:10px; border:2px solid #d7ccc8; background:white; color:#a1887f; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif;">
                        ✅ Después
                    </button>
                </div>
                <input type="hidden" id="tipo-archivo-val" value="antes">
                <button type="button" onclick="subirFoto('archivo')"
                    style="padding:10px 20px; border-radius:10px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; font-size:14px; border:none; cursor:pointer; font-family:Poppins,sans-serif; white-space:nowrap; box-shadow:0 2px 8px rgba(255,112,67,0.4);">
                    📤 Subir
                </button>
            </div>
        </div>

        {{-- TAB 2: Cámara en vivo --}}
        <div id="tab-camara" style="display:none;">
            <div style="border-radius:14px; overflow:hidden; background:#1a1a1a; text-align:center; min-height:120px; display:flex; align-items:center; justify-content:center; margin-bottom:14px;">
                <div id="camara-placeholder" style="color:#666; font-size:13px; padding:30px;">
                    <div style="font-size:32px; margin-bottom:8px;">🎥</div>
                    Haz clic en "Activar cámara" para comenzar
                </div>
                <video id="video-camara" autoplay playsinline style="display:none; width:100%; max-height:280px; object-fit:cover;"></video>
            </div>
            <canvas id="canvas-captura" style="display:none;"></canvas>

            {{-- Preview captura --}}
            <div id="preview-camara" style="display:none; text-align:center; margin-bottom:14px;">
                <div style="position:relative; display:inline-block; border-radius:12px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.12);">
                    <img id="img-preview-camara" src="" alt="captura" style="max-height:200px; display:block; border-radius:12px;">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.5), transparent); border-radius:12px;"></div>
                    <span style="position:absolute; bottom:8px; left:10px; color:white; font-size:12px; font-weight:600;">📸 Foto capturada</span>
                </div>
            </div>

            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <div style="display:flex; gap:6px; flex:1;">
                    <button type="button" onclick="seleccionarTipoCamara('antes')" id="tipo-camara-antes"
                        style="flex:1; padding:9px; border-radius:10px; border:2px solid #ff7043; background:#ff7043; color:white; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif;">
                        📷 Antes
                    </button>
                    <button type="button" onclick="seleccionarTipoCamara('despues')" id="tipo-camara-despues"
                        style="flex:1; padding:9px; border-radius:10px; border:2px solid #d7ccc8; background:white; color:#a1887f; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif;">
                        ✅ Después
                    </button>
                </div>
                <input type="hidden" id="tipo-camara-val" value="antes">

                <button type="button" onclick="iniciarCamara()" id="btn-iniciar-camara"
                    style="padding:9px 16px; border-radius:10px; background:#1565c0; color:white; font-weight:600; font-size:13px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    🎥 Activar
                </button>
                
                {{-- CORRECCIÓN AQUÍ: Fusionados los atributos style duplicados en una sola cadena limpia --}}
                <button type="button" onclick="capturarFoto()" id="btn-capturar"
                    style="display:none; padding:9px 16px; border-radius:10px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; font-size:13px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    📸 Capturar
                </button>
                <button type="button" onclick="reiniciarCamara()" id="btn-reiniciar"
                    style="display:none; padding:9px 16px; border-radius:10px; border:2px solid #d7ccc8; background:white; color:#5d4037; font-weight:600; font-size:13px; cursor:pointer; font-family:Poppins,sans-serif;">
                    🔄 Retomar
                </button>
                <button type="button" onclick="subirFoto('camara')" id="btn-subir-camara"
                    style="display:none; padding:9px 16px; border-radius:10px; background:linear-gradient(135deg,#2e7d32,#43a047); color:white; font-weight:600; font-size:13px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    📤 Subir
                </button>
            </div>
        </div>

        {{-- Barra de progreso --}}
        <div id="progreso-subida" style="display:none; margin-top:14px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                <span style="font-size:13px; color:#5d4037;">⏳ Subiendo foto...</span>
            </div>
            <div style="background:#f5f0eb; border-radius:8px; height:6px; overflow:hidden;">
                <div id="barra-progreso" style="height:100%; width:0%; background:linear-gradient(135deg,#ff7043,#ff8f00); transition:width 0.3s ease; border-radius:8px;"></div>
            </div>
        </div>

        {{-- Mensaje resultado --}}
        <div id="mensaje-subida" style="display:none; margin-top:12px; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:500;"></div>
        @endif

        {{-- GALERÍA --}}
        @if($ficha->fotos && $ficha->fotos->count() > 0)
        <div style="margin-top:20px; border-top:1px solid #f5f0eb; padding-top:16px;">
            {{-- Filtros --}}
            <div style="display:flex; gap:6px; margin-bottom:12px;">
                <button type="button" onclick="filtrarFotos('todas')" id="filtro-todas"
                    style="padding:5px 12px; border-radius:20px; border:none; background:#ff7043; color:white; font-size:12px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                    Todas
                </button>
                <button type="button" onclick="filtrarFotos('antes')" id="filtro-antes"
                    style="padding:5px 12px; border-radius:20px; border:1px solid #d7ccc8; background:white; color:#5d4037; font-size:12px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                    Antes
                </button>
                <button type="button" onclick="filtrarFotos('despues')" id="filtro-despues"
                    style="padding:5px 12px; border-radius:20px; border:1px solid #d7ccc8; background:white; color:#5d4037; font-size:12px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                    Después
                </button>
            </div>

            <div id="galeria-fotos" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px,1fr)); gap:10px;">
                @foreach($ficha->fotos as $foto)
                <div class="foto-item" data-tipo="{{ $foto->tipo }}"
                    style="position:relative; border-radius:12px; overflow:hidden; aspect-ratio:1/1; background:#f5f5f5; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.03)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('storage/' . ($foto->ruta ?? $foto->url)) }}"
                        alt="Foto {{ $foto->tipo }}"
                        style="width:100%; height:100%; object-fit:cover; cursor:pointer;"
                        onclick="abrirModalFoto(this.src)">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.45), transparent); pointer-events:none;"></div>
                    <span style="position:absolute; bottom:6px; left:8px; color:white; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">
                        {{ $foto->tipo === 'antes' ? '📷' : '✅' }} {{ $foto->tipo }}
                    </span>
                    @if(!$ficha->fecha_cierre)
                    <form method="POST" action="{{ route('groomer.ficha.foto.eliminar', $foto->id) }}" style="position:absolute; top:6px; right:6px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar esta foto?')"
                            style="width:24px; height:24px; border-radius:50%; background:rgba(0,0,0,0.55); color:white; border:none; font-size:13px; cursor:pointer; display:flex; align-items:center; justify-content:center; line-height:1; backdrop-filter:blur(4px);">
                            ✕
                        </button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div id="sin-fotos" style="margin-top:16px; padding:28px 20px; text-align:center; border:2px dashed #ffd0b5; border-radius:14px; background:#fff8f5;">
            <div style="font-size:36px; margin-bottom:8px;">📭</div>
            <p style="color:#a1887f; font-size:13px; margin:0; font-weight:500;">Aún no hay fotos para esta mascota</p>
            <p style="color:#d7ccc8; font-size:12px; margin:4px 0 0;">Sube fotos antes y después del servicio</p>
        </div>
        @endif
    </div>
</div>

{{-- Modal foto grande --}}
<div id="modal-foto" onclick="cerrarModalFoto()"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.9); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="position:relative; max-width:90vw; max-height:90vh;">
        <img id="modal-img" src="" alt="foto grande"
            style="max-width:90vw; max-height:90vh; border-radius:16px; object-fit:contain; box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <button onclick="cerrarModalFoto()"
            style="position:absolute; top:-12px; right:-12px; background:#ff7043; color:white; border:none; border-radius:50%; width:32px; height:32px; font-size:16px; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3);">✕</button>
    </div>
</div>

{{-- Checklist y formulario de actualización --}}
<form method="POST" action="{{ route('groomer.ficha.update', $ficha->id) }}">
    @csrf
    @method('PUT')
    <div class="stat-card" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">✅ Checklist del servicio</h3>

        @foreach($ficha->checklist as $check)
        <div style="display:flex; align-items:start; gap:12px; padding:12px 0; border-bottom:1px solid #f5f0eb; cursor:pointer;"
             onclick="toggleCheck({{ $check->item_id }})">
            
            <div id="box-{{ $check->item_id }}"
                style="width:22px; height:22px; border-radius:6px; border:2px solid #d7ccc8; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:2px; transition:all 0.2s;
                {{ $check->completado ? 'background:linear-gradient(135deg,#ff7043,#ff8f00); border-color:#ff7043;' : '' }}">
                @if($check->completado)
                <span style="color:white; font-size:14px;">✓</span>
                @endif
            </div>

            <input type="checkbox" 
                name="checklist[{{ $check->item_id }}][completado]"
                id="check-{{ $check->item_id }}"
                {{ $check->completado ? 'checked' : '' }}
                style="display:none;">

            <div style="flex:1;">
                <label style="font-size:14px; font-weight:600; color:#5d4037; cursor:pointer;
                    {{ $check->completado ? 'text-decoration:line-through; color:#a1887f;' : '' }}"
                    id="label-{{ $check->item_id }}">
                    {{ $check->item->nombre }}
                </label>
                @if($check->item->requiere_observacion)
                <input type="text" name="checklist[{{ $check->item_id }}][observacion]"
                    value="{{ $check->observacion }}"
                    placeholder="Observación requerida..."
                    onclick="event.stopPropagation()"
                    style="width:100%; border:1px solid #d7ccc8; border-radius:8px; padding:6px 10px; font-size:13px; outline:none; font-family:Poppins,sans-serif; margin-top:6px; box-sizing:border-box;">
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="stat-card" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:12px;">📝 Estado final</h3>
        <textarea name="estado_final" rows="3"
            style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical; box-sizing:border-box;"
            placeholder="Describe el estado final de la mascota...">{{ $ficha->estado_final }}</textarea>

        <div style="margin-top:12px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Notas internas</label>
            <textarea name="notas_internas" rows="2"
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical; box-sizing:border-box;"
                placeholder="Notas solo para el equipo...">{{ $ficha->notas_internas }}</textarea>
        </div>
    </div>

    <button type="submit"
        style="width:100%; background:linear-gradient(135deg,#1565c0,#1976d2); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif; margin-bottom:16px;">
        💾 Guardar cambios
    </button>
</form>

{{-- CORRECCIÓN ESTRUCTURAL AQUÍ: El bloque de INSUMOS ahora se anida DENTRO del contenedor responsivo principal --}}
@if(!$ficha->fecha_cierre)
    {{-- TARJETA INSUMOS (Activa) --}}
    <div class="stat-card" style="margin-bottom:16px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.06);">
        <div style="background:linear-gradient(135deg,#2e7d32,#43a047); padding:16px 20px; display:flex; align-items:center; gap:10px;">
            <span style="font-size:22px;">🧴</span>
            <div>
                <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Insumos utilizados</h3>
                <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Registra los productos usados en este servicio</p>
            </div>
            <div style="margin-left:auto; background:rgba(255,255,255,0.2); border-radius:20px; padding:4px 12px;">
                <span style="color:white; font-size:12px; font-weight:600;" id="contador-insumos">
                    {{ $ficha->insumos->count() }} producto(s)
                </span>
            </div>
        </div>

        <div style="padding:20px;">
            <form method="POST" action="{{ route('groomer.ficha.insumo.store', $ficha->id) }}"
                style="background:#f5f0eb; border-radius:14px; padding:16px; margin-bottom:20px;">
                @csrf
                <p style="font-size:13px; font-weight:700; color:#5d4037; margin-bottom:14px;">➕ Agregar insumo</p>

                <div style="display:grid; grid-template-columns:2fr 1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#5d4037; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Producto *</label>
                        <select name="producto_id" required
                            style="width:100%; border:1.5px solid #d7ccc8; border-radius:10px; padding:9px 14px; font-size:13px; font-family:Poppins,sans-serif; outline:none; background:white; box-sizing:border-box;">
                            <option value="">— Seleccionar producto —</option>
                            @foreach($productos as $p)
                                <option value="{{ $p->id }}" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $p->nombre }} (Stock: {{ $p->stock }}) {{ $p->stock <= $p->stock_minimo ? '⚠️' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#5d4037; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Cantidad *</label>
                        <input type="number" name="cantidad" min="0.1" step="0.1" value="1" required
                            style="width:100%; border:1.5px solid #d7ccc8; border-radius:10px; padding:9px 14px; font-size:13px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#5d4037; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Unidad</label>
                        <select name="unidad"
                            style="width:100%; border:1.5px solid #d7ccc8; border-radius:10px; padding:9px 14px; font-size:13px; font-family:Poppins,sans-serif; outline:none; background:white; box-sizing:border-box;">
                            <option value="unidad">Unidad</option>
                            <option value="ml">ml</option>
                            <option value="g">g</option>
                            <option value="aplicacion">Aplicación</option>
                            <option value="chorro">Chorro</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#5d4037; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">Observación <span style="color:#a1887f; font-weight:400; text-transform:none;">(opcional)</span></label>
                    <input type="text" name="observacion" maxlength="200"
                        placeholder="Ej: se aplicó shampoo especial para piel sensible..."
                        style="width:100%; border:1.5px solid #d7ccc8; border-radius:10px; padding:9px 14px; font-size:13px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
                </div>

                <button type="submit"
                    style="background:linear-gradient(135deg,#2e7d32,#43a047); color:white; font-weight:700; padding:9px 20px; border-radius:10px; border:none; cursor:pointer; font-size:13px; font-family:Poppins,sans-serif; box-shadow:0 2px 8px rgba(46,125,50,0.35);">
                    ✅ Registrar insumo
                </button>
            </form>

            @if($ficha->insumos->count() > 0)
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($ficha->insumos as $insumo)
                    <div style="display:flex; align-items:center; gap:12px; background:#f9f9f9; border:1px solid #f0ebe5; border-radius:10px; padding:10px 14px;">
                        <div style="background:linear-gradient(135deg,#2e7d32,#43a047); border-radius:8px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">🧴</div>
                        <div style="flex:1;">
                            <p style="font-size:13px; font-weight:700; color:#5d4037; margin:0;">{{ $insumo->producto->nombre }}</p>
                            <p style="font-size:12px; color:#a1887f; margin:2px 0 0;">
                                {{ $insumo->cantidad }} {{ $insumo->unidad }} @if($insumo->observacion) · {{ $insumo->observacion }} @endif
                            </p>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:11px; color:#a1887f; margin:0;">Stock restante</p>
                            <p style="font-size:13px; font-weight:700; color:{{ $insumo->producto->stock <= $insumo->producto->stock_minimo ? '#c62828' : '#2e7d32' }}; margin:0;">
                                {{ $insumo->producto->stock }} u.
                            </p>
                        </div>
                        <form method="POST" action="{{ route('groomer.ficha.insumo.destroy', [$ficha->id, $insumo->id]) }}">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este insumo?')"
                                style="background:#fff5f5; color:#c62828; border:1px solid #ffcdd2; border-radius:8px; padding:6px 10px; font-size:12px; cursor:pointer; font-family:Poppins,sans-serif;">✕</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:24px; border:2px dashed #d7ccc8; border-radius:12px; color:#a1887f;">
                    <div style="font-size:32px; margin-bottom:8px;">🧴</div>
                    <p style="font-size:13px; margin:0;">No se han registrado insumos aún.</p>
                </div>
            @endif
        </div>
    </div>
@else
    {{-- Ficha cerrada: Solo lectura de insumos --}}
    @if($ficha->insumos->count() > 0)
    <div class="stat-card" style="margin-bottom:16px; border-radius:16px; overflow:hidden; background: #fff; box-shadow:0 2px 12px rgba(0,0,0,0.06);">
        <div style="background:linear-gradient(135deg,#2e7d32,#43a047); padding:14px 20px; display:flex; align-items:center; gap:10px;">
            <span style="font-size:20px;">🧴</span>
            <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Insumos utilizados ({{ $ficha->insumos->count() }})</h3>
        </div>
        <div style="padding:16px; display:flex; flex-direction:column; gap:8px;">
            @foreach($ficha->insumos as $insumo)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f5f0eb; border-radius:8px;">
                <div>
                    <p style="font-size:13px; font-weight:600; color:#5d4037; margin:0;">🧴 {{ $insumo->producto->nombre }}</p>
                    @if($insumo->observacion)
                        <p style="font-size:11px; color:#a1887f; margin:2px 0 0;">{{ $insumo->observacion }}</p>
                    @endif
                </div>
                <span style="font-size:13px; font-weight:700; color:#2e7d32;">{{ $insumo->cantidad }} {{ $insumo->unidad }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endif

@if($errors->has('checklist'))
<div style="background:#ffebee; color:#c62828; border-left:4px solid #e53935; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:12px;">
    ⚠️ {{ $errors->first('checklist') }}
</div>
@endif

    {{-- Botón final para Cerrar ficha --}}
    @if(!$ficha->fecha_cierre)
    <form method="POST" action="{{ route('groomer.ficha.cerrar', $ficha->id) }}">
        @csrf
        <button type="submit"
            onclick="return confirm('¿Cerrar la ficha? El cliente será notificado que puede recoger a su mascota.')"
            style="width:100%; background:linear-gradient(135deg,#2e7d32,#43a047); color:white; font-weight:700; padding:14px; border-radius:10px; border:none; cursor:pointer; font-size:15px; font-family:Poppins,sans-serif; margin-bottom:20px;">
            🎉 Cerrar ficha y notificar al cliente
        </button>
    </form>
    @else
    <div style="background:#e8f5e9; color:#2e7d32; border-radius:10px; padding:14px; text-align:center; font-weight:600; margin-bottom:20px;">
        ✅ Ficha cerrada el {{ $ficha->fecha_cierre->format('d/m/Y H:i') }}
    </div>
    @endif

</div> {{-- CORRECCIÓN: El div de 700px cierra de forma segura cubriendo todo el layout --}}

<script>
const FICHA_ID = {{ $ficha->id }};
const CSRF     = '{{ csrf_token() }}';
const FOTO_URL = '{{ route("groomer.ficha.foto", $ficha->id) }}';
let streamCamara  = null;
let blobCapturado = null;
let tipoArchivo   = 'antes';
let tipoCamara    = 'antes';

// ── Tabs ──────────────────────────────────────────────────────
function mostrarTab(tab) {
    const esArchivo = tab === 'tab-archivo';
    document.getElementById('tab-archivo').style.display = esArchivo ? 'block' : 'none';
    document.getElementById('tab-camara').style.display  = esArchivo ? 'none'  : 'block';
    const btnA = document.getElementById('btn-archivo');
    const btnC = document.getElementById('btn-camara');
    btnA.style.background  = esArchivo ? 'white' : 'transparent';
    btnA.style.color        = esArchivo ? '#ff7043' : '#a1887f';
    btnA.style.fontWeight   = esArchivo ? '700' : '600';
    btnA.style.boxShadow    = esArchivo ? '0 1px 4px rgba(0,0,0,0.1)' : 'none';
    btnC.style.background  = !esArchivo ? 'white' : 'transparent';
    btnC.style.color        = !esArchivo ? '#ff7043' : '#a1887f';
    btnC.style.fontWeight   = !esArchivo ? '700' : '600';
    btnC.style.boxShadow    = !esArchivo ? '0 1px 4px rgba(0,0,0,0.1)' : 'none';
    if (esArchivo) detenerCamara();
}

// ── Tipo selector ─────────────────────────────────────────────
function seleccionarTipoArchivo(val) {
    tipoArchivo = val;
    document.getElementById('tipo-archivo-val').value = val;
    estiloTipo('tipo-archivo-antes', 'tipo-archivo-despues', val === 'antes');
}
function seleccionarTipoCamara(val) {
    tipoCamara = val;
    document.getElementById('tipo-camara-val').value = val;
    estiloTipo('tipo-camara-antes', 'tipo-camara-despues', val === 'antes');
}
function estiloTipo(idA, idD, antesActivo) {
    const a = document.getElementById(idA);
    const d = document.getElementById(idD);
    a.style.background  = antesActivo ? '#ff7043' : 'white';
    a.style.color        = antesActivo ? 'white'   : '#a1887f';
    a.style.borderColor  = antesActivo ? '#ff7043' : '#d7ccc8';
    d.style.background  = !antesActivo ? '#ff7043' : 'white';
    d.style.color        = !antesActivo ? 'white'   : '#a1887f';
    d.style.borderColor  = !antesActivo ? '#ff7043' : '#d7ccc8';
}

// ── Drag & Drop ───────────────────────────────────────────────
function soltarArchivo(event) {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (!file) return;
    document.getElementById('input-archivo').files = event.dataTransfer.files;
    previsualizarDesdeFile(file);
}

// ── Vista previa archivo ──────────────────────────────────────
function previsualizarArchivo(event) {
    const file = event.target.files[0];
    if (file) previsualizarDesdeFile(file);
}
function previsualizarDesdeFile(file) {
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview-archivo').src = e.target.result;
        document.getElementById('preview-archivo').style.display = 'block';
    };
    reader.readAsDataURL(file);
}
function limpiarPreviewArchivo() {
    document.getElementById('input-archivo').value = '';
    document.getElementById('preview-archivo').style.display = 'none';
}

// ── Cámara ────────────────────────────────────────────────────
async function iniciarCamara() {
    try {
        streamCamara = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
        const video = document.getElementById('video-camara');
        video.srcObject = streamCamara;
        video.style.display = 'block';
        document.getElementById('camara-placeholder').style.display = 'none';
        document.getElementById('btn-iniciar-camara').style.display = 'none';
        document.getElementById('btn-capturar').style.display = 'inline-block';
        document.getElementById('preview-camara').style.display = 'none';
        document.getElementById('btn-reiniciar').style.display = 'none';
        document.getElementById('btn-subir-camara').style.display = 'none';
    } catch(e) {
        mostrarMensaje('⚠️ No se pudo acceder a la cámara. Verifica los permisos.', 'error');
    }
}
function detenerCamara() {
    if (streamCamara) { streamCamara.getTracks().forEach(t => t.stop()); streamCamara = null; }
    const video = document.getElementById('video-camara');
    if (video) { video.style.display = 'none'; video.srcObject = null; }
    const pl = document.getElementById('camara-placeholder');
    if (pl) pl.style.display = 'flex';
    const bc = document.getElementById('btn-capturar');
    if (bc) bc.style.display = 'none';
    const bi = document.getElementById('btn-iniciar-camara');
    if (bi) bi.style.display = 'inline-block';
    blobCapturado = null;
}
function capturarFoto() {
    const video = document.getElementById('video-camara');
    const canvas = document.getElementById('canvas-captura');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    canvas.toBlob(blob => {
        blobCapturado = blob;
        document.getElementById('img-preview-camara').src = URL.createObjectURL(blob);
        document.getElementById('preview-camara').style.display = 'block';
        video.style.display = 'none';
        document.getElementById('btn-capturar').style.display = 'none';
        document.getElementById('btn-reiniciar').style.display = 'inline-block';
        document.getElementById('btn-subir-camara').style.display = 'inline-block';
    }, 'image/jpeg', 0.92);
}
function reiniciarCamara() {
    blobCapturado = null;
    document.getElementById('preview-camara').style.display = 'none';
    document.getElementById('video-camara').style.display = 'block';
    document.getElementById('btn-capturar').style.display = 'inline-block';
    document.getElementById('btn-reiniciar').style.display = 'none';
    document.getElementById('btn-subir-camara').style.display = 'none';
}

// ── Subida AJAX ───────────────────────────────────────────────
function subirFoto(fuente) {
    const formData = new FormData();
    formData.append('_token', CSRF);
    if (fuente === 'archivo') {
        const input = document.getElementById('input-archivo');
        if (!input.files[0]) { mostrarMensaje('⚠️ Selecciona una imagen primero.', 'error'); return; }
        formData.append('foto', input.files[0]);
        formData.append('tipo', document.getElementById('tipo-archivo-val').value);
    } else {
        if (!blobCapturado) { mostrarMensaje('⚠️ Captura una foto primero.', 'error'); return; }
        formData.append('foto', blobCapturado, 'captura.jpg');
        formData.append('tipo', document.getElementById('tipo-camara-val').value);
    }
    document.getElementById('progreso-subida').style.display = 'block';
    document.getElementById('mensaje-subida').style.display = 'none';
    animarBarra();
    fetch(FOTO_URL, { method: 'POST', body: formData })
        .then(async r => {
            document.getElementById('barra-progreso').style.width = '100%';
            if (r.ok || r.redirected) {
                mostrarMensaje('✅ Foto subida correctamente.', 'exito');
                setTimeout(() => location.reload(), 800);
            } else {
                mostrarMensaje('❌ No se pudo subir la foto. Intenta de nuevo.', 'error');
            }
        })
        .catch(() => mostrarMensaje('❌ Error de conexión.', 'error'))
        .finally(() => {
            setTimeout(() => {
                document.getElementById('progreso-subida').style.display = 'none';
                document.getElementById('barra-progreso').style.width = '0%';
            }, 1200);
        });
}
function animarBarra() {
    let w = 0;
    const barra = document.getElementById('barra-progreso');
    const iv = setInterval(() => {
        w = Math.min(w + Math.random() * 18, 90);
        barra.style.width = w + '%';
        if (w >= 90) clearInterval(iv);
    }, 180);
}
function mostrarMensaje(texto, tipo) {
    const el = document.getElementById('mensaje-subida');
    el.style.display  = 'block';
    el.style.background = tipo === 'exito' ? '#e8f5e9' : '#fff3e0';
    el.style.color      = tipo === 'exito' ? '#2e7d32' : '#e65100';
    el.style.border     = tipo === 'exito' ? '1px solid #a5d6a7' : '1px solid #ffcc80';
    el.textContent = texto;
}

// ── Filtros galería ───────────────────────────────────────────
function filtrarFotos(tipo) {
    document.querySelectorAll('.foto-item').forEach(el => {
        el.style.display = (tipo === 'todas' || el.dataset.tipo === tipo) ? 'block' : 'none';
    });
    ['todas','antes','despues'].forEach(t => {
        const btn = document.getElementById('filtro-' + t);
        if (!btn) return;
        btn.style.background   = t === tipo ? '#ff7043' : 'white';
        btn.style.color        = t === tipo ? 'white'   : '#5d4037';
        btn.style.border       = t === tipo ? 'none'    : '1px solid #d7ccc8';
    });
}

// ── Modal ─────────────────────────────────────────────────────
function abrirModalFoto(src) {
    document.getElementById('modal-img').src = src;
    document.getElementById('modal-foto').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function cerrarModalFoto() {
    document.getElementById('modal-foto').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModalFoto(); });

// ── Checklist interactivo ──────────────────────────────────────
function toggleCheck(itemId) {
    const checkbox = document.getElementById('check-' + itemId);
    const box      = document.getElementById('box-' + itemId);
    const label    = document.getElementById('label-' + itemId);

    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        box.style.background = 'linear-gradient(135deg,#ff7043,#ff8f00)';
        box.style.borderColor = '#ff7043';
        box.innerHTML = '<span style="color:white; font-size:14px;">✓</span>';
        label.style.textDecoration = 'line-through';
        label.style.color = '#a1887f';
    } else {
        box.style.background = 'white';
        box.style.borderColor = '#d7ccc8';
        box.innerHTML = '';
        label.style.textDecoration = 'none';
        label.style.color = '#5d4037';
    }
}
</script>
@endsection
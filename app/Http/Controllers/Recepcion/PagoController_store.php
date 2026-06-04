    public function store(Request $request, $citaId)
    {
        $request->validate([
            'metodo'        => 'required|in:efectivo,qr,transferencia',
            'descuento'     => 'nullable|numeric|min:0',
            'referencia'    => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:300',
        ]);

        $cita     = Cita::with(['servicio', 'mascota', 'creadoPor'])->findOrFail($citaId);
        $monto    = $cita->precio_acordado;
        $descuento = $request->descuento ?? 0;
        $total    = max(0, $monto - $descuento);

        $pago = Pago::updateOrCreate(
            ['cita_id' => $citaId],
            [
                'metodo'         => $request->metodo,
                'monto'          => $monto,
                'descuento'      => $descuento,
                'total'          => $total,
                'referencia'     => $request->referencia,
                'observaciones'  => $request->observaciones,
                'estado'         => 'pagado',
                'registrado_por' => Auth::id(),
            ]
        );

        // Enviar email al cliente
        $emailCliente = $cita->creadoPor?->email;
        if ($emailCliente) {
            try {
                \Illuminate\Support\Facades\Mail::to($emailCliente)
                    ->send(new \App\Mail\PagoRegistradoMail($pago->load(['cita.mascota', 'cita.servicio', 'cita.creadoPor'])));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('No se pudo enviar email de pago: ' . $e->getMessage());
            }
        }

        return redirect()->route('recepcion.pagos.index')
            ->with('status', "✅ Pago de Bs. {$total} registrado correctamente.");
    }

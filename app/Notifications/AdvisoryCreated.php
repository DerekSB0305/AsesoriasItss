<?php

namespace App\Notifications;

use App\Models\Advisories;
use Illuminate\Notifications\Notification;

class AdvisoryCreated extends Notification
{
    protected $advisory;

    public function __construct(Advisories $advisory)
    {
        $this->advisory = $advisory;
    }

    public function via($notifiable)
    {
        return ['database']; // SOLO NOTIFICACIÓN INTERNA
    }

    public function toDatabase($notifiable)
    {
        // Cargamos las relaciones necesarias por si no vienen cargadas
        $advisory = $this->advisory->loadMissing([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'advisoryDetail.requests.subject.career',
        ]);

        // 🔥 Misma lógica que usas en myAdvisories()
        $solicitud = optional($advisory->advisoryDetail->requests)->first();

        $materiaSolicitada  = $solicitud?->subject?->name ?? 'Materia común';
        $carreraSolicitada  = $solicitud?->subject?->career?->name ?? 'Materia común';

        return [
            'title'        => 'Nueva asesoría asignada',
            'teacher'      => $advisory->teacherSubject->teacher->name,
            'subject'      => $materiaSolicitada,   // 👈 ahora es la materia de la asesoría
            'career'       => $carreraSolicitada,   // (opcional, por si luego la quieres en la vista)
            'advisory_id'  => $advisory->advisory_id,
        ];
    }
}

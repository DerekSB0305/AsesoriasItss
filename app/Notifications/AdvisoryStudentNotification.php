<?php

namespace App\Notifications;

use App\Models\Advisories;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdvisoryStudentNotification extends Notification
{
    use Queueable;

    public $advisory;

    public function __construct(Advisories $advisory)
    {
        $this->advisory = $advisory;
    }

    // MUY IMPORTANTE PARA QUE SE GUARDE EN NOTIFICATIONS
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Cargamos relaciones necesarias por si no vienen cargadas
        $advisory = $this->advisory->loadMissing([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'advisoryDetail.requests.subject.career',
        ]);

        // Igual que en myAdvisories / AdvisoryCreated
        $solicitud = optional($advisory->advisoryDetail->requests)->first();

        $materiaSolicitada = $solicitud?->subject?->name
            ?? $advisory->teacherSubject->subject?->name
            ?? 'Materia común';

        $carreraSolicitada = $solicitud?->subject?->career?->name ?? null;

        return [
            'message' => "Se te ha asignado una asesoría de la materia: " . $materiaSolicitada,
            'advisory_id' => $advisory->advisory_id,
            'date' => $advisory->start_date,
            'teacher' => $advisory->teacherSubject->teacher->name . ' ' .
                         $advisory->teacherSubject->teacher->last_name_f,

            // opcionales, por si luego quieres usarlos en la vista
            'subject' => $materiaSolicitada,
            'career'  => $carreraSolicitada,
        ];
    }
}

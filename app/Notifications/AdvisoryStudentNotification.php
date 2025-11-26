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
        return [
            'message' => "Se te ha asignado una asesoría de la materia: " .
                         $this->advisory->teacherSubject->subject->name,
            'advisory_id' => $this->advisory->advisory_id,
            'date' => $this->advisory->start_date,
            'teacher' => $this->advisory->teacherSubject->teacher->name . ' ' .
                         $this->advisory->teacherSubject->teacher->last_name_f,
        ];
    }
}

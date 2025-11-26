<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AdvisoryCreated extends Notification
{
    protected $advisory;

    public function __construct($advisory)
    {
        $this->advisory = $advisory;
    }

    public function via($notifiable)
    {
        return ['database']; // SOLO NOTIFICACIÓN INTERNA
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nueva asesoría asignada',
            'teacher' => $this->advisory->teacherSubject->teacher->name,
            'subject' => $this->advisory->teacherSubject->subject->name,
            'advisory_id' => $this->advisory->advisory_id
        ];
    }
}

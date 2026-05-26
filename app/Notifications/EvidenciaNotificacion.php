<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EvidenciaNotificacion extends Notification
{
    use Queueable;

    public $mensaje;
    public $url;
    public $icono;

    public function __construct($mensaje, $url, $icono)
    {
        $this->mensaje = $mensaje;
        $this->url = $url;
        $this->icono = $icono;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'mensaje' => $this->mensaje,
            'url' => $this->url,
            'icono' => $this->icono,
        ];
    }
}

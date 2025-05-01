<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Enviar una notificación a un usuario
     *
     * @param User $user Usuario que recibirá la notificación
     * @param string $type Tipo de notificación (system, team, project, etc)
     * @param string $title Título corto de la notificación
     * @param string $message Mensaje completo de la notificación
     * @param string|null $icon Ícono para la notificación (svg o class)
     * @param string|null $actionUrl URL para redireccionar al hacer click
     * @param array|null $data Datos adicionales relacionados con la notificación
     * @return Notification
     */
    public static function send(User $user, string $type, string $title, string $message, ?string $icon = null, ?string $actionUrl = null, ?array $data = null)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'action_url' => $actionUrl,
            'data' => $data,
            'is_read' => false,
        ]);
    }
    
    /**
     * Enviar una notificación de sistema a un usuario
     */
    public static function sendSystem(User $user, string $title, string $message, ?string $actionUrl = null, ?array $data = null)
    {
        return self::send(
            $user,
            'system',
            $title,
            $message,
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
            $actionUrl,
            $data
        );
    }
    
    /**
     * Enviar una notificación de equipo a un usuario
     */
    public static function sendTeam(User $user, string $title, string $message, ?string $actionUrl = null, ?array $data = null)
    {
        return self::send(
            $user,
            'team',
            $title,
            $message,
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            $actionUrl,
            $data
        );
    }
    
    /**
     * Enviar una notificación de proyecto a un usuario
     */
    public static function sendProject(User $user, string $title, string $message, ?string $actionUrl = null, ?array $data = null)
    {
        return self::send(
            $user,
            'project',
            $title,
            $message,
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
            $actionUrl,
            $data
        );
    }
}

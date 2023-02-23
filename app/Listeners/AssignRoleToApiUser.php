<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;

class AssignRoleToApiUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user->provider === null) {
            // Si el usuario no se ha registrado con un proveedor externo, se le asigna el rol de jetstream-user.
            $role = Role::where('name', 'jetstream-user')->firstOrFail();
            $event->user->assignRole($role);
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSelfDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_no_puede_eliminarse_a_si_mismo()
    {
        // 1. Crear un usuario de prueba
        $user = User::factory()->create(
            [
                'email_verified_at' => now(),
            ]
        );

        // 2. Simular que el usuario ha iniciado sesión
        $this->actingAs($user, 'web');

        // 3. Intentar eliminar al usuario a sí mismo
        $response = $this->delete(route('admin.users.destroy', $user));

        // 4. Esperar que el servidor bloquee la acción (403 Forbidden)
        $response->assertStatus(403);

        // 5. Verificar que el usuario aún existe en la base de datos
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    } 
} 
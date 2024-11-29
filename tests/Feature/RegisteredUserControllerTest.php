<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisteredUserControllerTest extends TestCase
{
   

    public function test_user_can_be_created_successfully()
    {
        // Criar um utilizador administrador para autenticação
        $admin = User::factory()->create(['nivel_acesso' => 'admin']);
        $this->actingAs($admin);

        // Gerar um email único
        $email = 'user' . uniqid() . '@example.com';

        // Enviar a requisição para criar um utilizador
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nivel_acesso' => 'operador',
        ]);

        // Verificar o redirecionamento e a mensagem de sucesso
        $response->assertRedirect(route('users.index'))
                ->assertSessionHas('success', 'Utilizador criado com sucesso!');

        // Garantir que o utilizador foi adicionado à base de dados
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => 'John Doe',
            'nivel_acesso' => 'operador',
        ]);
    }

    #Teste de Atualização de Utilizador
    public function test_user_can_be_updated_successfully()
    {
        $admin = User::factory()->create(['nivel_acesso' => 'admin']);
        $this->actingAs($admin);

        $user = User::factory()->create();

        $response = $this->put(route('users.update', $user), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'nivel_acesso' => 'admin',
        ]);

        $response->assertRedirect(route('users.index'))
                ->assertSessionHas('success', 'Utilizador atualizado com sucesso!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'nivel_acesso' => 'admin',
        ]);
    }


    #Teste de Eliminação de Utilizador
    public function test_user_can_be_deleted_successfully()
    {
        // Criar um utilizador administrador para autenticação
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);
        $this->actingAs($admin); // Autenticar como administrador

        // Criar um utilizador a ser excluído
        $user = \App\Models\User::factory()->create();

        // Enviar a requisição de exclusão
        $response = $this->delete(route('destroy', $user));

        // Verificar redirecionamento e mensagem de sucesso
        $response->assertRedirect(route('users.index'))
                 ->assertSessionHas('success', 'Utilizador excluído com sucesso!');

        // Garantir que o utilizador foi removido da base de dados
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    #Teste de Listagem de Utilizadores
    public function test_users_index_page_is_accessible()
    {
        // Criar e autenticar um utilizador administrador
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);
        $this->actingAs($admin);

        // Fazer uma requisição para a rota `users.index`
        $response = $this->get(route('users.index'));

        // Verificar que o status é 200 e a visualização está correta
        $response->assertStatus(200)
                 ->assertViewIs('funcionario.user_index')
                 ->assertViewHas('users');
    }

    #Teste de Redirecionamento Não-Autorizado
    public function test_unauthorized_user_cannot_access_protected_routes()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
    }

   # Teste de Login de Utilizador
   # Verifica se um utilizador consegue autenticar-se com credenciais válidas.


    public function test_user_can_login_successfully()
    {
        $password = 'password123';
        $user = \App\Models\User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    #Teste de Logout de Utilizador
    #Garante que o logout funciona corretamente.


    public function test_user_can_logout_successfully()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('inicio'));
        $this->assertGuest();
    }

    #Teste de Busca de Utilizadores
    #Verifica se a funcionalidade de busca retorna os resultados esperados.
    

    public function test_admin_can_access_users_index()
    {
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);

        $this->actingAs($admin);

        $response = $this->get(route('users.index'));

        $response->assertStatus(200)
                ->assertViewIs('funcionario.user_index');
    }

    

    public function test_admin_can_access_create_user_form()
    {
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);

        $this->actingAs($admin);

        $response = $this->get(route('register'));

        $response->assertStatus(200)
                ->assertViewIs('auth.register');
    }



    public function test_admin_can_update_user()
    {
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);
        $user = \App\Models\User::factory()->create();

        $this->actingAs($admin);

        $response = $this->put(route('users.update', $user), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'nivel_acesso' => 'gerente',
        ]);

        $response->assertRedirect(route('users.index'))
                ->assertSessionHas('success', 'Utilizador atualizado com sucesso!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

   

    public function test_admin_can_delete_user()
    {
        $admin = \App\Models\User::factory()->create(['nivel_acesso' => 'admin']);
        $user = \App\Models\User::factory()->create();

        $this->actingAs($admin);

        $response = $this->delete(route('destroy', $user));

        $response->assertRedirect(route('users.index'))
                ->assertSessionHas('success', 'Utilizador excluído com sucesso!');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

   
    public function test_guest_cannot_access_protected_routes()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
    }

}

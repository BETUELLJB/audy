@extends('layouts.app')

@section('title', 'Funcionários')

@section('header')
<h1>Bem-vindo à Página de Funcionários</h1>
@endsection

@section('content')
<div class="container">
    <h1>funcionarios</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Adicionar Funcionario</button>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Sexo</th>
                <th>Contacto</th>
                <th>Profissão</th>
                <th>N-Cartão</th>
                <th>NIB</th>
                <th>Estado Médico</th>
                <th>Diagnóstico</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($funcionarios as $funcionario)
            <tr>
                <td>{{ $funcionario->id }}</td>
                <td>{{ $funcionario->nome }}</td>
                <td>{{ $funcionario->idade }}</td>
                <td>{{ $funcionario->sexo }}</td>
                <td>{{ $funcionario->contacto }}</td>
                <td>{{ $funcionario->tipo_trabalho }}</td>
                <td>{{ $funcionario->cartao_credito}}</td>
                <td>{{ $funcionario->NIB }}</td>
                <td>{{ $funcionario->condicao_saude }}</td>
                <td>{{ $funcionario->historico_comportamento }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="{{ $funcionario->id }}"
                            data-nome="{{ $funcionario->nome }}"
                            data-password="" 
                            data-email="{{ $funcionario->email }}"
                            data-contacto="{{ $funcionario->contacto }}"
                            data-idade="{{ $funcionario->idade }}"
                            data-sexo="{{ $funcionario->sexo }}"
                            data-bi="{{ $funcionario->bi }}"
                            data-data-nascimento="{{ $funcionario->data_nascimento }}"
                            data-data-expiracao="{{ $funcionario->data_expiracao }}"
                            data-tipo-trabalho="{{ $funcionario->tipo_trabalho }}"
                            data-cartao-credito="{{ $funcionario->cartao_credito }}"
                            data-nib="{{ $funcionario->NIB }}"
                            data-rua="{{ $funcionario->rua }}"
                            data-cidade="{{ $funcionario->cidade }}"
                            data-codigo-postal="{{ $funcionario->codigo_postal }}"
                            data-pais="{{ $funcionario->pais }}"
                            data-condicao-saude="{{ $funcionario->condicao_saude }}"
                            data-medicamento="{{ $funcionario->medicamento }}"
                            data-historico-comportamento="{{ $funcionario->historico_comportamento }}">
                        Editar
                    </button>

                    <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-id="{{ $funcionario->id }}">
                        Apagar
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Nenhum Funcionário encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<!-- Modal Criar Funcionário -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('funcionarios.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Adicionar Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Contacto -->
                    <div class="mb-3">
                        <label for="contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" required>
                    </div>

                    <!-- Idade -->
                    <div class="mb-3">
                        <label for="idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="idade" name="idade" required>
                    </div>

                    <!-- Sexo -->
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo" required>
                            <option value="">Selecionar</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>

                    <!-- BI -->
                    <div class="mb-3">
                        <label for="bi" class="form-label">BI</label>
                        <input type="text" class="form-control" id="bi" name="bi" required>
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>

                    <!-- Data de Expiração -->
                    <div class="mb-3">
                        <label for="data_expiracao" class="form-label">Data de Expiração</label>
                        <input type="date" class="form-control" id="data_expiracao" name="data_expiracao" required>
                    </div>

                    <!-- Tipo de Trabalho -->
                    <div class="mb-3">
                        <label for="tipo_trabalho" class="form-label">Tipo de Trabalho</label>
                        <input type="text" class="form-control" id="tipo_trabalho" name="tipo_trabalho" required>
                    </div>

                    <!-- Cartão de Crédito -->
                    <div class="mb-3">
                        <label for="cartao_credito" class="form-label">Cartão de Crédito</label>
                        <input type="text" class="form-control" id="cartao_credito" name="cartao_credito" required>
                    </div>

                    <!-- NIB -->
                    <div class="mb-3">
                        <label for="NIB" class="form-label">NIB</label>
                        <input type="text" class="form-control" id="NIB" name="NIB" required>
                    </div>

                    <!-- Rua -->
                    <div class="mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua" required>
                    </div>

                    <!-- Cidade -->
                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>

                    <!-- Código Postal -->
                    <div class="mb-3">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
                    </div>

                    <!-- País -->
                    <div class="mb-3">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" class="form-control" id="pais" name="pais" required>
                    </div>

                    <!-- Condição de Saúde -->
                    <div class="mb-3">
                        <label for="condicao_saude" class="form-label">Condição de Saúde</label>
                        <textarea class="form-control" id="condicao_saude" name="condicao_saude" required></textarea>
                    </div>

                    <!-- Medicamento -->
                    <div class="mb-3">
                        <label for="medicamento" class="form-label">Medicamento</label>
                        <textarea class="form-control" id="medicamento" name="medicamento" required></textarea>
                    </div>

                    <!-- Histórico de Comportamento -->
                    <div class="mb-3">
                        <label for="historico_comportamento" class="form-label">Histórico de Comportamento</label>
                        <textarea class="form-control" id="historico_comportamento" name="historico_comportamento" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Funcionário -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>
                    <!-- Palavra-passe -->
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Palavra-passe</label>
                        <input type="password" class="form-control" id="edit_password" name="password" required>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <!-- Contacto -->
                    <div class="mb-3">
                        <label for="edit_contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="edit_contacto" name="contacto" required>
                    </div>
                    <!-- Idade -->
                    <div class="mb-3">
                        <label for="edit_idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="edit_idade" name="idade" required>
                    </div>
                    <!-- Sexo -->
                    <div class="mb-3">
                        <label for="edit_sexo" class="form-label">Sexo</label>
                        <input type="text" class="form-control" id="edit_sexo" name="sexo" required>
                    </div>
                    <!-- BI -->
                    <div class="mb-3">
                        <label for="edit_bi" class="form-label">BI</label>
                        <input type="text" class="form-control" id="edit_bi" name="bi" required>
                    </div>
                    <!-- Data de nascimento -->
                    <div class="mb-3">
                        <label for="edit_data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="edit_data_nascimento" name="data_nascimento" required>
                    </div>
                    <!-- Data de expiração -->
                    <div class="mb-3">
                        <label for="edit_data_expiracao" class="form-label">Data de Expiração</label>
                        <input type="date" class="form-control" id="edit_data_expiracao" name="data_expiracao" required>
                    </div>
                    <!-- Tipo de trabalho -->
                    <div class="mb-3">
                        <label for="edit_tipo_trabalho" class="form-label">Tipo de Trabalho</label>
                        <input type="text" class="form-control" id="edit_tipo_trabalho" name="tipo_trabalho" required>
                    </div>
                    <!-- Cartão de crédito -->
                    <div class="mb-3">
                        <label for="edit_cartao_credito" class="form-label">Cartão de Crédito</label>
                        <input type="text" class="form-control" id="edit_cartao_credito" name="cartao_credito" required>
                    </div>
                    <!-- NIB -->
                    <div class="mb-3">
                        <label for="edit_nib" class="form-label">NIB</label>
                        <input type="text" class="form-control" id="edit_nib" name="nib" required>
                    </div>
                    <!-- Rua -->
                    <div class="mb-3">
                        <label for="edit_rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="edit_rua" name="rua" required>
                    </div>
                    <!-- Cidade -->
                    <div class="mb-3">
                        <label for="edit_cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="edit_cidade" name="cidade" required>
                    </div>
                    <!-- Código Postal -->
                    <div class="mb-3">
                        <label for="edit_codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" id="edit_codigo_postal" name="codigo_postal" required>
                    </div>
                    <!-- País -->
                    <div class="mb-3">
                        <label for="edit_pais" class="form-label">País</label>
                        <input type="text" class="form-control" id="edit_pais" name="pais" required>
                    </div>
                    <!-- Condição de Saúde -->
                    <div class="mb-3">
                        <label for="edit_condicao_saude" class="form-label">Condição de Saúde</label>
                        <input type="text" class="form-control" id="edit_condicao_saude" name="condicao_saude" required>
                    </div>
                    <!-- Medicamento -->
                    <div class="mb-3">
                        <label for="edit_medicamento" class="form-label">Medicamento</label>
                        <input type="text" class="form-control" id="edit_medicamento" name="medicamento" required>
                    </div>
                    <!-- Histórico de Comportamento -->
                    <div class="mb-3">
                        <label for="edit_historico_comportamento" class="form-label">Histórico de Comportamento</label>
                        <textarea class="form-control" id="edit_historico_comportamento" name="historico_comportamento" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja apagar os dados do funcionário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
   // Preencher dados no modal de edição
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        // Preencher campos individuais
        document.getElementById('edit_nome').value = button.getAttribute('data-nome');
        document.getElementById('edit_password').value = ''; // Por segurança, deixar o campo vazio
        document.getElementById('edit_email').value = button.getAttribute('data-email');
        document.getElementById('edit_contacto').value = button.getAttribute('data-contacto');
        document.getElementById('edit_idade').value = button.getAttribute('data-idade');
        document.getElementById('edit_sexo').value = button.getAttribute('data-sexo');
        document.getElementById('edit_bi').value = button.getAttribute('data-bi');
        document.getElementById('edit_data_nascimento').value = button.getAttribute('data-data_nascimento');
        document.getElementById('edit_data_expiracao').value = button.getAttribute('data-data_expiracao');
        document.getElementById('edit_tipo_trabalho').value = button.getAttribute('data-tipo_trabalho');
        document.getElementById('edit_cartao_credito').value = button.getAttribute('data-cartao_credito');
        document.getElementById('edit_nib').value = button.getAttribute('data-nib');
        document.getElementById('edit_rua').value = button.getAttribute('data-rua');
        document.getElementById('edit_cidade').value = button.getAttribute('data-cidade');
        document.getElementById('edit_codigo_postal').value = button.getAttribute('data-codigo_postal');
        document.getElementById('edit_pais').value = button.getAttribute('data-pais');
        document.getElementById('edit_condicao_saude').value = button.getAttribute('data-condicao_saude');
        document.getElementById('edit_medicamento').value = button.getAttribute('data-medicamento');
        document.getElementById('edit_historico_comportamento').value = button.getAttribute('data-historico_comportamento');

        // Atualizar a ação do formulário com o ID correto
        document.getElementById('editForm').action = `/funcionarios/${button.getAttribute('data-id')}`;
    });


    // Preencher dados no modal de exclusão
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('deleteForm').action = `/funcionarios/${button.getAttribute('data-id')}`;
    });
</script>

@endsection
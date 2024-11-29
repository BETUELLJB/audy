<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Log;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        

        // Exibir todos os pacientes
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        

        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->nivel_acesso !== 'admin') {
            return redirect()->back()->with('error', 'Apenas administradores podem criar pacientes.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'estado_medico' => 'required|string',
            'consultas' => 'required|string',
            'diagnostico' => 'required|string',
            'medicamentos' => 'required|string',
        ]);

        try {
            $paciente = Paciente::create($request->all());

            // Registrar log de sucesso
            $this->logAction(auth()->id(), 'Paciente', $paciente->id, 'create', $paciente->toArray(), 'success', 'Paciente criado com sucesso.');

            return redirect()->route('pacientes.index')->with('success', 'Paciente criado com sucesso!');
        } catch (\Exception $e) {
            // Registrar log de erro
            $this->logAction(auth()->id(), 'Paciente', null, 'create', null, 'error', $e->getMessage());

            return redirect()->back()->with('error', 'Erro ao criar paciente.');
        }
    }

    public function show(Paciente $paciente)
    {
        if (!in_array(auth()->user()->nivel_acesso, ['admin', 'gerente'])) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        if (auth()->user()->nivel_acesso !== 'admin') {
            return redirect()->back()->with('error', 'Apenas administradores podem editar pacientes.');
        }

        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        if (auth()->user()->nivel_acesso !== 'admin') {
            return redirect()->back()->with('error', 'Apenas administradores podem atualizar pacientes.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'estado_medico' => 'required|string',
            'consultas' => 'required|string',
            'diagnostico' => 'required|string',
            'medicamentos' => 'required|string',
        ]);

        try {
            $changes = $paciente->getChanges();
            $paciente->update($request->all());

            // Registrar log de sucesso
            $this->logAction(auth()->id(), 'Paciente', $paciente->id, 'update', $changes, 'success', 'Paciente atualizado com sucesso.');

            return redirect()->route('pacientes.index')->with('success', 'Paciente atualizado com sucesso!');
        } catch (\Exception $e) {
            // Registrar log de erro
            $this->logAction(auth()->id(), 'Paciente', $paciente->id, 'update', null, 'error', $e->getMessage());

            return redirect()->back()->with('error', 'Erro ao atualizar paciente.');
        }
    }

    public function destroy(Paciente $paciente)
    {
        if (auth()->user()->nivel_acesso !== 'admin') {
            return redirect()->back()->with('error', 'Apenas administradores podem remover pacientes.');
        }

        try {
            $paciente->delete();

            // Registrar log de sucesso
            $this->logAction(auth()->id(), 'Paciente', $paciente->id, 'delete', null, 'success', 'Paciente removido com sucesso.');

            return redirect()->route('pacientes.index')->with('success', 'Paciente removido com sucesso!');
        } catch (\Exception $e) {
            // Registrar log de erro
            $this->logAction(auth()->id(), 'Paciente', $paciente->id, 'delete', null, 'error', $e->getMessage());

            return redirect()->back()->with('error', 'Erro ao remover paciente.');
        }
    }

    private function logAction($userId, $model, $modelId, $action, $changes, $status, $message)
    {
        Log::create([
            'user_id' => $userId,
            'model' => $model,
            'model_id' => $modelId,
            'action' => $action,
            'changes' => $changes,
            'status' => $status,
            'message' => $message,
        ]);
    }
}

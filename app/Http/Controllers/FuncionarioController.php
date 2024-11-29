<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Funcionario;
use App\Services\LogService; // Importação do LogService

class FuncionarioController extends Controller
{
    public function index()
    {
    
        $funcionarios = Funcionario::all();
        return view('funcionario.index', compact('funcionarios'));
    }

    public function create()
    {
        
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'password'=> 'required|min:8',
            'email' => 'required|email|unique:funcionarios',
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'bi' => 'required|string',
            'data_nascimento' => 'required|string',
            'data_expiracao' => 'required|string',
            'tipo_trabalho' => 'required|string',
            'cartao_credito' => 'required|string',
            'NIB' => 'required|string',
            'rua' => 'required|string',
            'cidade' => 'required|string',
            'codigo_postal' => 'required|string',
            'pais' => 'required|string',
            'condicao_saude' => 'required|string',
            'medicamento' => 'required|string',
            'historico_comportamento' => 'required|string',
        ]);
        
        DB::beginTransaction();
        try {
            $funcionario = Funcionario::create($request->all());

            // Registrar log de sucesso
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Funcionario::class,
                'model_id' => $funcionario->id,
                'action' => 'create',
                'changes' => $funcionario->toArray(),
                'status' => 'success',
                'message' => 'Funcionário criado com sucesso.',
                'ip_address' => $request->ip(),
            ]);

            DB::commit(); // Confirma as alterações no banco de dados

            return redirect()->route('funcoinario.index')->with('success', 'funcoinario criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações no banco de dados em caso de erro

            // Registrar log de erro
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Funcionario::class,
                'action' => 'create',
                'status' => 'error',
                'message' => 'Erro ao criar funcionario: ' . $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()->with('error', 'Erro ao criar funcoinario.');
        }
    }

    public function show(Funcionario $funcionario)
    {
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        // Validação dos campos
        $request->validate([
            'nome' => 'required|string|max:255',
            'password' => 'nullable|min:8',
            'email' => 'required|email|unique:funcionarios,email,' . $funcionario->id,
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'bi' => 'required|string',
            'data_nascimento' => 'required|string',
            'data_expiracao' => 'required|string',
            'tipo_trabalho' => 'required|string',
            'cartao_credito' => 'required|string',
            'NIB' => 'required|string',
            'rua' => 'required|string',
            'cidade' => 'required|string',
            'codigo_postal' => 'required|string',
            'pais' => 'required|string',
            'condicao_saude' => 'required|string',
            'medicamento' => 'required|string',
            'historico_comportamento' => 'required|string',
        ]);
    
        try {
            // Iniciar transação
            DB::beginTransaction();
    
            $data = $request->all();
    
            // Encriptação do e-mail
            if ($request->filled('email')) {
                $data['email'] = Crypt::encryptString($data['email']);
            }
    
            // Atualização da senha apenas se fornecida
            if ($request->filled('password')) {
                $data['password'] = bcrypt($data['password']);
            }
    
            // Atualizar os dados do funcionário
            $funcionario->update($data);
    
            // Commit da transação
            DB::commit();
    
            return redirect()->route('funcionario.index')->with('success', 'Funcionário atualizado com sucesso.');
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            DB::rollBack();
            return redirect()->route('funcionario.index')->with('error', 'Erro ao atualizar o funcionário: ' . $e->getMessage());
        }
    }
    
    public function destroy(Funcionario $funcionario)
    {
        try {
            // Iniciar transação
            DB::beginTransaction();
    
            // Apagar o funcionário
            $funcionario->delete();
    
            // Commit da transação
            DB::commit();
    
            return redirect()->route('funcionarios.index')->with('success', 'Funcionário removido com sucesso.');
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            DB::rollBack();
            return redirect()->route('funcionarios.index')->with('error', 'Erro ao remover o funcionário: ' . $e->getMessage());
        }
    }
    
}

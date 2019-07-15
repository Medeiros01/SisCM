<?php

namespace App\Http\Controllers;
use DB;
use App\Cliente;
use App\User;
use App\utis\MyLog;
use Auth;
use Illuminate\Http\Request;

/**
 * Controller da Cargo (dbo.cargos)
 */
class ClienteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->all())){
        $clientes = DB::table('clientes')
                    ->where([['st_nome', 'like', '%'.$request->st_cliente.'%'],['bo_ativo', 1]])
                    ->orwhere([['st_cpf','like', '%'.$request->st_cliente.'%'],['bo_ativo', 1]])
                    ->orwhere([['st_rg','like', '%'.$request->st_cliente.'%'],['bo_ativo', 1]])
                    ->get();
        }else{

            $clientes = Cliente::where('bo_ativo', 1)->orderBy('st_nome')->get();
        }

        
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'clietes.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        //MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos cargos. */
        $Msg = "Nenhum cliente encontrado.";
       
        if(count($clientes) >= 1){
              
            return view('cliente.Listaclientes', compact('clientes', 'total'));
        }else{
            return view('cliente.Listaclientes', compact('Msg'));
            //return view('cliente.Listaclientes')->with('erroMsg', 'Nenhum cliente encontrado.');    
            /** Redireciona para a listagem de cargos. */
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Administrador');
        return view('cliente.Form_cad_cliente');         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->authorize('cadastrar');
        /** Iniciando a transação no banco de dados. */
        DB:: beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'st_nome' => 'required|max:255',       
            'st_cpf' => 'max:14|unique:clientes',       
            'st_rg' => 'max:20|unique:clientes',
            'st_endereco' => 'max:255',
            'st_municipio' => 'max:50',
            'st_celular' => 'max:20',
            'st_tel_fixo' => 'max:20',
            'st_email' => 'max:255',

            ]);
        
        /** Se a validação falhar, mensagens de erro serão exibidas. */
        if($validator->fails()){
           
            return redirect()->back()
            /** Mensagem de Erro */         
                ->withErrors($validator)
           /** Preenchendo o Formulário */         
                ->withInput();
        }
        /** Inserindo o cliente */
        $insert = Cliente::create($dadosForm);
       
        /** Tentando inserir o cliente no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou o cargo de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de clientes. */
            return redirect('/clientes');
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o Clientes');  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $cliente = cliente::find($id);
       
        if(!empty($cliente)){

            return view('cliente.Form_edita_cliente', compact('cliente'));
        }else{
            return redirect()->back()->with('erroMsg', 'Não existe cliente cadastrado em nosso banco de dados com o parâmetro informado.');  
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->authorize('Administrador');
        /** Iniciando a transação no banco de dados. */
        DB::beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'st_nome' => 'required|max:255',       
            'st_cpf' => "max:14|unique:clientes,st_cpf,$id",       
            'st_rg' => "max:20|unique:clientes,st_rg,$id",
            'st_endereco' => 'max:255',
            'st_municipio' => 'max:50',
            'st_celular' => 'max:20',
            'st_tel_fixo' => 'max:20',
            'st_email' => 'max:255',
       
            ]);
        /**
         * Se a validação falhar, mensagens de erro serão exibidas.
         */
        if($validator->fails()){     
            return redirect()->back()
            /** Mensagem de Erro */        
                ->withErrors($validator)
            /** Preenchendo o Formulário */          
                ->withInput();
        }
        /** Buscando na tabela o cargo que será editado */
        $cliente = Cliente::find($id);
        //se não encontrar o cliente, retorna para a rota anterior infomando que não existe o cliente para editar
        if(empty($cliente)){
            return redirect()->back()->with('erroMsg', 'Não existe cliente cadastrado em nosso banco de dados com o parâmetro informado.');
        }
        /** Editando o cargo de acordo com os dados do formulário */
        $clienteeditado = $cliente->update($dadosForm); 

        /** Editando o cargo */
        if($clienteeditado){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou os dados do cliente ID número: ' .$cliente->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de cargos */
            return redirect('/clientes')->with('sucessoMsg', 'Cliente alterado com sucesso');

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar os dados do cliente');  
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
  
    
}

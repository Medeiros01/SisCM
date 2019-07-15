<?php

namespace App\Http\Controllers;
use DB;
use App\Fornecedor;
use App\User;
use App\utis\MyLog;
use Auth;
use Illuminate\Http\Request;

/**
 * Controller da fornecedor (dbo.fornecedors)
 */
class FornecedorController extends Controller
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
        $fornecedores = DB::table('fornecedores')
                    ->where([['st_nome', 'like', '%'.$request->st_fornecedor.'%'],['bo_ativo', 1]])
                    ->orwhere([['st_cnpj_cpf', 'like', '%'.$request->st_fornecedor.'%'],['bo_ativo', 1]])
                    ->orderBy('st_nome')
                    ->get();
        }else{

            $fornecedores = Fornecedor::where('bo_ativo', 1)->orderBy('st_nome')->get();
        }

        
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'listou os fornecedores.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        //MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos fornecedors. */
        $Msg = "Nenhum fornecedor encontrado.";
        if(count($fornecedores) >= 1){
              
            return view('fornecedor.Listafornecedor', compact('fornecedores', 'total'));
        }else{
            return view('fornecedor.Listafornecedor', compact('Msg'));
            //return view('cliente.Listaclientes')->with('erroMsg', 'Nenhum cliente encontrado.');    
            /** Redireciona para a listagem de fornecedors. */
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
      
        return view('fornecedor.Form_cad_fornecedor');         
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
            'st_nome' => 'required|max:255|unique:fornecedores',       
            'st_descricao' => 'max:255',       
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
        $insert = Fornecedor::create($dadosForm);
       
        /** Tentando inserir o cliente no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou o fornecedor de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de clientes. */
            return redirect('/fornecedores');
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
        $fornecedor = Fornecedor::find($id);
       
        if(!empty($fornecedor)){
           
            return view('fornecedor.Form_edita_fornecedor', compact('fornecedor'));
        }else{
            return redirect()->back()->with('erroMsg', 'Não existe fornecedor cadastrado em nosso banco de dados com o parâmetro informado.');  
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
            'st_nome' => "required|max:255|unique:fornecedores,st_nome, $id",       
            'st_descricao' => "max:255|"
       
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
        /** Buscando na tabela o fornecedor que será editado */
        $fornecedor = Fornecedor::find($id);
        //se não encontrar o cliente, retorna para a rota anterior infomando que não existe o cliente para editar
        if(empty($fornecedor)){
            return redirect()->back()->with('erroMsg', 'Não existe fornecedor cadastrado em nosso banco de dados com o parâmetro informado.');
        }
        /** Editando o fornecedor de acordo com os dados do formulário */
        $fornecedoreditado = $fornecedor->update($dadosForm); 

        /** Editando o fornecedor */
        if($fornecedoreditado){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou os dados do fornecedor ID número: ' .$fornecedor->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de fornecedores */
            return redirect('/fornecedores')->with('sucessoMsg', 'Fornecedor alterado com sucesso');

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar a fornecedor');  
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
  
    
}

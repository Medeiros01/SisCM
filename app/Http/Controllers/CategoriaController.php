<?php

namespace App\Http\Controllers;
use DB;
use App\Cliente;
use App\Categoria;
use App\User;
use App\utis\MyLog;
use Auth;
use Illuminate\Http\Request;

/**
 * Controller da Cargo (dbo.cargos)
 */
class CategoriaController extends Controller
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
        $categorias = DB::table('categorias')
                    ->where([['st_nome', 'like', '%'.$request->st_categoria.'%'],['bo_ativo', 1]])
                    ->orderBy('st_nome')
                    ->get();
        }else{

            $categorias = Categoria::where('bo_ativo', 1)->orderBy('st_nome')->get();
        }

        
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'listou as categorias.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        //MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos cargos. */
        $Msg = "Nenhuma categoria encontradoa.";
        if(count($categorias) >= 1){
              
            return view('categoria.Listacategoria', compact('categorias', 'total'));
        }else{
            return view('categoria.Listacategoria', compact('Msg'));
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
        return view('categoria.Form_cad_categoria');         
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
            'st_nome' => 'required|max:255|unique:categorias',       
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
        $insert = Categoria::create($dadosForm);
       
        /** Tentando inserir o cliente no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou a categoria de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de clientes. */
            return redirect('/categorias');
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
        $categoria = Categoria::find($id);
       
        if(!empty($categoria)){

            return view('categoria.Form_edita_categoria', compact('categoria'));
        }else{
            return redirect()->back()->with('erroMsg', 'Não existe categoria cadastrada em nosso banco de dados com o parâmetro informado.');  
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
            'st_nome' => "required|max:255|unique:categorias,st_nome, $id",       
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
        /** Buscando na tabela o cargo que será editado */
        $categoria = Categoria::find($id);
        //se não encontrar o cliente, retorna para a rota anterior infomando que não existe o cliente para editar
        if(empty($categoria)){
            return redirect()->back()->with('erroMsg', 'Não existe cliente cadastrado em nosso banco de dados com o parâmetro informado.');
        }
        /** Editando o cargo de acordo com os dados do formulário */
        $categoriaeditada = $categoria->update($dadosForm); 

        /** Editando o cargo */
        if($categoriaeditada){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou os dados da categoria ID número: ' .$categoria->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de cargos */
            return redirect('/categorias')->with('sucessoMsg', 'Categoria alterada com sucesso');

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar a categoria');  
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
  
    
}

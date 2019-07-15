<?php

namespace App\Http\Controllers;
use DB;
use App\Produto;
use App\User;
use App\utis\MyLog;
use Auth;
use App\Opm;
use Illuminate\Http\Request;

/**
 * Controller da produto (dbo.produtos)
 */
class ProdutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $dados= null;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
  
    /* public function getparente($childs)
    {
        foreach($childs as $child){
            echo $child->st_descricao.'<br/>';

            if(count($child->filhos)){
                $this->getparente($child->filhos);
            }
            

            
        }
    } */
    public function getarvore($childs){
        foreach($childs as $child){
            echo $child->st_descricao.'<br/>';
            if(count($child->filhos)){
                $filhos = $child->filhos;
                $this->getarvore( $filhos);
            }
            
        }
    }
    public function getfilhos()
    {
        $regiarvore = Opm::where('id', 6)->get();
        //return view('arvore', compact('regiarvore'));
       
        foreach($regiarvore as $category){

                    echo $category->st_descricao.'<br/>';
                    $childs = $category->filhos;
                    $this->getarvore($childs);
                    
                       
                   
         }
       
        
      
    }
    public function index(Request $request)
    {

        
       

       $st_produto = ""; 
        if(!empty($request->all()) && !empty($request['st_produto'])){
            $st_produto = $request['st_produto'];
            $produtos = DB::table('produtos as p')
                        ->where([['p.st_nome', 'like', '%'.$request->st_produto.'%'],['p.bo_ativo', 1]])
                        ->orwhere([['p.st_codigo', 'like', '%'.$request->st_produto.'%'],['p.bo_ativo', 1]])
                        ->orwhere([['p.st_descricao', 'like', '%'.$request->st_produto.'%'],['p.bo_ativo', 1]])
                        ->leftjoin('categorias as c','c.id', 'p.ce_categoria')
                        ->leftjoin('fornecedores as f','f.id', 'p.ce_fornecedor')
                        ->select('p.*', 'c.st_nome as st_nome_categoria', 'f.st_nome as st_nome_fornecedor')
                        ->orderBy('p.st_nome')
                        ->paginate(30);
            }else{
    
                $produtos = DB::table('produtos as p')
                ->where('p.bo_ativo', 1)->orderby('p.st_nome')
                ->leftjoin('categorias as c','c.id', 'p.ce_categoria')
                ->leftjoin('fornecedores as f','f.id', 'p.ce_fornecedor')
                ->select('p.*', 'c.st_nome as st_nome_categoria', 'f.st_nome as st_nome_fornecedor')
                ->orderBy('p.st_nome')
                ->paginate(30);
            }
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou os produtos.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        //MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos produtos. */
        return view('produto.Listaprodutos', compact('produtos', 'st_produto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('cad_produtos');
        $fornecedores = DB::table('fornecedores')->where('bo_ativo', 1)->get();
        $categorias = DB::table('categorias')->where('bo_ativo', 1)->get();
        return view('produto.Form_cad_produto', compact('fornecedores', 'categorias'));         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('cad_produtos');
        /** Iniciando a transação no banco de dados. */
        DB:: beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        /** Validando os dados */
       
        /** Inserindo o produto */
        $insert = Produto::create($dadosForm) ;
       
        /** Tentando inserir o produto no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou o produto de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de produtos. */
            return redirect('/produtos');
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o produto');  
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
        $this->authorize('cad_produtos');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $produto = produto::find($id);
       
        $fornecedores = DB::table('fornecedores')->where('bo_ativo', 1)->get();
        $categorias = DB::table('categorias')->where('bo_ativo', 1)->get();

        return view('produto.Form_edita_produto', compact('produto', 'fornecedores', 'categorias'));
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
        $this->authorize('cad_produtos');
        /** Iniciando a transação no banco de dados. */
        DB::beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        $dadosForm['st_preco_custo'] = str_replace(".","", $dadosForm['st_preco_custo']);
        $dadosForm['st_preco_custo'] = str_replace(",",".", $dadosForm['st_preco_custo']);
        $dadosForm['st_preco_venda'] = str_replace(".","", $dadosForm['st_preco_venda']);
        $dadosForm['st_preco_venda'] = str_replace(",",".", $dadosForm['st_preco_venda']);
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'st_nome' => "required|max:2550|unique:produtos,st_nome,$id",
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
        /** Buscando na tabela o produto que será editado */
        $produto = produto::find($id);
        /** Editando o produto de acordo com os dados do formulário */
        $produtoeditado = $produto->update($dadosForm); 

        /** Editando o produto */
        if($produtoeditado){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou o produto de ID número: ' .$produto->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de produtos */
            return redirect('/produtos');

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar o produto');  
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleta($id)
    { $this->authorize('cad_produtos');
        /** Busca na tabela o produto a ser excluído */
        $produto = produto::find($id);
        /** Desativa ("deleta") o produto setando o bo_ativo para 0 */
        $produtoalterado = $produto->update([
            'bo_ativo' => 0
        ]);

        /** Cadastra a ação na tabela log no banco. */
        $acao = "Remoção";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o produto de ID número: ' .$produto->id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Redireciona para a listagem de produtos. */
        return redirect('/produtos');
    }
  
    
}

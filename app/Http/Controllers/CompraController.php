<?php

namespace App\Http\Controllers;
use DB;
use App\Compra;
use App\User;
use App\Detalhecompra;
use App\Produto;
use App\utis\MyLog;
use Auth;

use Illuminate\Http\Request;


/**
 * Controller da compra (dbo.compras)
 */
class CompraController extends Controller
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
        $dadosform = $request->all();
       
       
       // dd( $dadosform['st_campo']);
        $campo = '';
        $fornecedor = '';
        $valor = '';
        $datainicio = '';
        $datafim = '';

        if(isset($dadosform['st_campo'])){
               
            $campo = $dadosform['st_campo'];
            $datainicio = $dadosform['dt_compra_inicio'];
            $datafim = $dadosform['dt_compra_fim'];
            if($campo == 'ce_fornecedor'){
                $valor = $dadosform['ce_fornecedor'];
                
            }else if($campo == 'st_notafiscal'){
                $valor = $dadosform['st_valor'];
            }
           
            
            if($campo != 'dt_periodo'){
               
                $compras = DB::table('compras as c')
                ->where([['c.'.$campo, 'like', '%'.$valor.'%'],['c.bo_ativo', 1]])
                ->leftjoin('fornecedores as f','f.id', 'c.ce_fornecedor')
                ->select('c.*', 'f.st_nome as st_nome_fornecedor')
                ->orderBy('c.id', 'desc')
                ->paginate(30);
               
            }else{
                
                $compras = DB::table('compras as c')
                ->whereBetween('c.dt_compra', [$datainicio, $datafim])
                ->where('c.bo_ativo', 1)
                ->leftjoin('fornecedores as f','f.id', 'c.ce_fornecedor')
                ->select('c.*', 'f.st_nome as st_nome_fornecedor')
                ->orderBy('c.id', 'desc')
                ->paginate(30);
            

            
            }

        }else{

            $compras = DB::table('compras as c')
            ->where('c.bo_ativo', 1)
            ->leftjoin('fornecedores as f','f.id', 'c.ce_fornecedor')
            ->select('c.*', 'f.st_nome as st_nome_fornecedor')
            ->orderBy('c.id', 'desc')
            ->paginate(30);
        }
        $fornecedores = DB::table('fornecedores', 'bo_ativo', 1)->orderby('st_nome')->get();
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou as compras.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        //MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos compras. */
        return view('compra.Listacompras', compact('compras', 'fornecedores', 'campo', 'valor', 'datainicio', 'datafim', 'fornecedor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Administrador');
        $fornecedores = DB::table('fornecedores')->where('bo_ativo', 1)->get();
        return view('compra.Form_cad_compra', compact('fornecedores', 'categorias'));         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Administrador');
        /** Iniciando a transação no banco de dados. */
        DB:: beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        /** Validando os dados */
       $usuario = Auth::user()->id;
      
        /** alterando dados dos campos */
        $dadosForm['st_valor_compra'] = str_replace(".","", $dadosForm['st_valor_compra']);
        $dadosForm['st_valor_compra'] = str_replace(",",".", $dadosForm['st_valor_compra']);
        $dadosForm['ce_usuario'] = $usuario;
        
        /** Inserindo a compra */
        $insert = Compra::create($dadosForm) ;
        /** Tentando inserir o compra no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou o compra de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de compras. */
            return redirect('/compras');
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o compra');  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscaprodutosparaadicionarnacompra(Request $request,  $idcompra)
    {
        
        
        $dadosForm = $request->all();
       
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $compra = DB::table('compras as c')->where('c.id',$idcompra)
                        ->leftjoin('fornecedores as f', 'f.id', 'c.ce_fornecedor' )
                        ->select('c.*', 'f.st_nome as st_nome_fornecedor')
                        ->first();
        if( empty($compra)){
            return redirect()->back()->with('erroMsg', 'A compra para a qual você que inserir o produto não encontrada!!');
        }
        
        if($request->ajax()){
           
            $buscaprodutos = DB::table('produtos as p')
            ->where([['p.ce_fornecedor', $compra->ce_fornecedor],['p.bo_ativo', 1], ['p.st_codigo', $request->input('st_produto')]])
            ->leftjoin('fornecedores as f', 'f.id', 'p.ce_fornecedor')
            ->select('p.*', 'f.st_nome as st_nome_fornecedor')
            ->orderby('p.st_nome')
            ->first();
            if(!empty($buscaprodutos)){
                
                return response()->json( $buscaprodutos);
            } else{
                return 0;           
            }
        }
            $produtoscomprados = DB::table('detalhecompras as d')
            ->where('d.ce_compra', $idcompra)
            ->leftjoin('produtos as p', 'p.id', 'd.ce_produto' ) 
            ->select('d.*', 'p.st_codigo', 'p.st_nome')
            ->orderby('d.id', 'desc')
            ->get(); 
            
      /*  return response()->json('1'); */
        return view('compra.Detalhecompra', compact('compra', 'buscaprodutos', 'produtoscomprados'));
    }
    public function show($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $compra = DB::table('compras as c')->where([['c.bo_ativo', 1],['c.id', $id]])
                    ->leftjoin('fornecedores as f', 'c.ce_fornecedor', 'f.id')
                    ->select('c.*', 'f.st_nome as st_nome_fornecedor')
                    ->first();
        if( empty($compra)){
            return redirect()->back()->with('erroMsg', 'Compra não encontrada!!');
        }
        
        return view('compra.Detalhecompra', compact('compra'));
    }

    public function edit($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $compra = compra::find($id);
        if( $compra->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'O estoque já foi atualizado com esta compra. Por isso, não é possivel fazer alteração em seus dados!'); 
        }
       
        $fornecedores = DB::table('fornecedores')->where('bo_ativo', 1)->get();

        return view('compra.Form_edita_compra', compact('compra', 'fornecedores'));
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
        $dadosForm['st_valor_compra'] = str_replace(".","", $dadosForm['st_valor_compra']);
        $dadosForm['st_valor_compra'] = str_replace(",",".", $dadosForm['st_valor_compra']);
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'dt_compra' => "required",
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
        /** Buscando na tabela o compra que será editado */
        $compra = compra::find($id);
        if( $compra->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'O estoque já foi atualizado com esta compra. Por isso, não é possivel fazer alteração em seus dados!'); 
        }
        /** Editando o compra de acordo com os dados do formulário */
        $compraeditada = $compra->update($dadosForm); 

        /** Editando o compra */
        if($compraeditada){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a compra de ID número: ' .$compra->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de compras */
            return redirect('/compras')->with('sucessoMsg', 'Dados Atualizados com sucesso!'); 

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar o compra');  
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleta($id)
    { $this->authorize('Administrador');
        /** Busca na tabela o compra a ser excluído */
        $compra = compra::find($id);
        /** Desativa ("deleta") o compra setando o bo_ativo para 0 */
        
        $compraalterado = $compra->update([
            'bo_ativo' => 0
        ]);

        /** Cadastra a ação na tabela log no banco. */
        $acao = "Remoção";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o compra de ID número: ' .$compra->id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Redireciona para a listagem de compras. */
        return redirect('/compras');
    }
    public function add_produto(Request $request, $idcompra)
    {
         $this->authorize('Administrador');
        /** Busca na tabela o compra a ser excluído */
        $compra = compra::find($idcompra);
        if( $compra->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'Esta compra já foi finalizada. Por isso, não é possível adicionar produto a compra!'); 
        }
       // dd($request->all());
        $dadosform = $request->all();
       
        $produto = DB::table('produtos')->where('st_codigo',  $dadosform['st_codigo'])->first();
        if(empty($produto)){
            return redirect()->back()->with('erroMsg', 'Código do produto não encontrado!'); 
        }
        $produtosdacompra =  DB::table('detalhecompras')->where('ce_compra',  $idcompra)->get();
        
        if(count($produtosdacompra)>0){
            foreach($produtosdacompra as $p){
                if($p->ce_produto == $produto->id){
                    return redirect()->back()->with('erroMsg', 'Produto ja adicionado a lista de compra!'); 
                }
            }
        }
        $dadosform['st_preco_custo'] = str_replace(".","", $dadosform['st_preco_custo']);
        $dadosform['st_preco_custo'] = str_replace(",",".", $dadosform['st_preco_custo']);
        $dadosform['st_preco_venda'] = str_replace(".","", $dadosform['st_preco_venda']);
        $dadosform['st_preco_venda'] = str_replace(",",".", $dadosform['st_preco_venda']);
        $insert = Detalhecompra::create([
            'ce_compra' => $idcompra,
            'ce_produto' => $produto->id,
            'nu_quantidade' => $dadosform['nu_quantidade'],
            'st_preco_custo' => $dadosform['st_preco_custo'],
            'st_preco_venda' => $dadosform['st_preco_venda'],
            ]);
            
            /** Redireciona para a detalhe da compra. */
            return redirect()->back()->with('sucessoMsg', 'Produto adicionado com sucesso!'); 
        }
        
        public function remove_detalhe(Request $request, $iddetalhecompra)
        {
            $this->authorize('Administrador');
            
            $produtodetalhe = Detalhecompra::find($iddetalhecompra);
            if(!empty($produtodetalhe)){
                $compra = Compra::find($produtodetalhe->ce_compra);
               if($compra->bo_atualizouestoque == 1){

                   return redirect()->back()->with('erroMsg', 'Não é possível remover um produto de um compra finalizada!'); 
                }

                $delete = $produtodetalhe->delete();
                if($delete){
                    return redirect()->back()->with('sucessoMsg', 'Produto Removido com sucesso!'); 
                    
                }else{
                    return redirect()->back()->with('erroMsg', 'Erro ao remover o produto!'); 
                    
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Produto não encontrado!'); 
            }
        
        }
        public function concluir_compra(Request $request, $idcompra)
        {
            $this->authorize('Administrador');
            
            $compra = Compra::find( $idcompra);
            if(empty($compra)){
                return redirect()->back()->with('erroMsg', 'Compra não encontrada!'); 
            }
            /**
             * resgatando os produtos da compra
             */
            $produtoscomprados = DB::table('detalhecompras')->where('ce_compra', $idcompra)->get();
            if(isset($produtoscomprados) && count($produtoscomprados) > 0){
                foreach($produtoscomprados as $p){
                    $produtonoestoque = Produto::find($p->ce_produto);
                    $total = $produtonoestoque->nu_disponivel + $p->nu_quantidade;
                    /**
                     * Atualizando a quantidade de produtos no estoque
                     */
                    $produtoatualizado =  $produtonoestoque->update([
                        'nu_disponivel'=> $total,
                        'st_preco_custo'=> $p->st_preco_custo,
                        'st_preco_venda'=> $p->st_preco_venda,
                        ]);
                  
                }
                $compraatualizada = $compra->update(["bo_atualizouestoque" =>  1,]);
              
                 return redirect()->back()->with('sucessoMsg', 'Compra finalizada e estoque atualizado com sucesso!'); 
                }else{
                    $compra->update([
                        "bo_atualizouestoque" =>1, 
                        ]);

                    return redirect()->back()->with('sucessoMsg', 'Compra finalizada e estoque atualizado com sucesso!'); 

            }
            if(!empty($compra)){
               if($compra){

                }

                $delete = $compra->delete();
                if($delete){
                    return redirect()->back()->with('sucessoMsg', 'Produto Removido com sucesso!'); 
                    
                }else{
                    return redirect()->back()->with('erroMsg', 'Erro ao remover o produto!'); 
                    
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Produto não encontrado!'); 
            }
        
        }
       
}

<?php

namespace App\Http\Controllers;
use DB;
use App\Compra;
use App\User;
use App\Venda;
use App\Detalhecompra;
use App\Produto;
use App\Detalhevenda;
use App\Detalhescaixa;
use App\utis\MyLog;
use PDF;
use Auth;

use Illuminate\Http\Request;


/**
 * Controller da venda (dbo.vendas)
 */
class VendaController extends Controller
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
    public function index($tipo)
    {
        $titulo = 'Vendas';
        if($tipo == 'orcamentos'){
            $tipo = "Orçamento";
            $titulo = 'Orçamentos';
        }
        $vendas = DB::table('vendas as v')->where('v.st_tipo', $tipo)
                    ->leftjoin('clientes as c', 'c.id', 'v.ce_cliente')
                    ->leftjoin('users as u', 'u.id', 'v.ce_vendedor')
                    ->select('v.*', 'c.st_nome as st_nome_cliente', 'u.name as st_nome_vendedor')
                    ->orderby('dt_venda', 'desc')
                    ->paginate(30); 
        return view('venda.Listavendas',compact('vendas', 'tipo'));  

    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo)
    {
        $this->authorize('Administrador');

        return view('venda.Form_cad_venda', compact('tipo'));         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($tipo)
    {
       if($tipo == 'orcamento'){
        $tipo = 'Orçamento'; 
       }
        $this->authorize('Administrador');
        /** Iniciando a transação no banco de dados. */
        DB:: beginTransaction();
        /** Recebendo os dados do formulário */
       
        /** Validando os dados */
       $usuario = Auth::user()->id;
       $codigovenda = Venda::where('dt_cadastro','like',  date('Y-m-d').'%')->orderby('nu_codigo', 'desc')->select('nu_codigo')->first();
   
       if(empty($codigovenda) ||empty($codigovenda->nu_codigo)){
          $codigo = 1;
      }else{
        $codigo =  $codigovenda->nu_codigo + 1;
      }
     

        /** Inserindo a venda */
        $insert = Venda::create([
            'ce_cliente' => 1,
            'ce_vendedor' =>Auth::user()->id,
            'st_tipo' => $tipo, 
            'nu_codigo' => $codigo, 
            'dt_venda' => date('Y-m-d H:m:s'), 
        ]) ;
        /** Tentando inserir o compra no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou venda de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de vanda. */
            return redirect('/venda/detalhe/'.$insert->id);
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar a venda');  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscaprodutosparaadicionarnavenda(Request $request, $idvenda)
    {
        
        
        $dadosForm = $request->all();
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = Venda::find($idvenda);
        if( empty($venda)){
            return redirect()->back()->with('erroMsg', 'A venda para a qual você que inserir o produto não foi encontrada!!');
        }
        
        if($request->ajax()){
           
            $buscaprodutos = DB::table('produtos as p')
            ->where([['p.bo_ativo', 1], ['p.st_codigo', $request->input('st_produto')]])
            ->first();
            if(!empty($buscaprodutos)){
                
                return response()->json( $buscaprodutos);
            } else{
                return 0;           
            }
        }
            
    }
    public function show($id)
    {
       
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = DB::table('vendas as v')->where('v.id', $id)
                    ->leftjoin('clientes as c', 'c.id', 'v.ce_cliente')
                    ->leftjoin('users as u', 'u.id', 'v.ce_vendedor')
                    ->select('v.*', 'c.st_nome as st_nome_cliente', 'u.name as st_nome_vendedor')
                    ->first();
        if( empty($venda)){
            return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!!');
        }


        $produtosvendidos = DB::table('detalhevendas as d')
            ->where('d.ce_venda', $id)
            ->leftjoin('produtos as p', 'p.id', 'd.ce_produto' ) 
            ->select('d.*', 'p.st_codigo', 'p.st_descricao', 'p.st_preco_venda')
            ->orderby('d.id', 'desc')
            ->get();

        return view('venda.Detalhevenda', compact('venda', 'produtosvendidos'));
    }
    public function imprmivenda_orcamento($id)
    {
       
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = DB::table('vendas as v')->where('v.id', $id)
                    ->leftjoin('clientes as c', 'c.id', 'v.ce_cliente')
                    ->leftjoin('users as u', 'u.id', 'v.ce_vendedor')
                    ->select('v.*', 'c.st_nome as st_nome_cliente', 'u.name as st_nome_vendedor')
                    ->first();
        if( empty($venda)){
            return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!!');
        }


        $produtosvendidos = DB::table('detalhevendas as d')
            ->where('d.ce_venda', $id)
            ->leftjoin('produtos as p', 'p.id', 'd.ce_produto' ) 
            ->select('d.*', 'p.st_codigo', 'p.st_descricao', 'p.st_preco_venda')
            ->orderby('d.id', 'desc')
            ->get();

             $pdf = PDF::loadview('venda.Pdfimpressao', compact('venda', 'buscaprodutos', 'produtosvendidos'));
            return $pdf->stream();
    }
    public function cancelar_venda($id)
    {
       
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = Venda::find($id);

                if( empty($venda)){
            return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!!');
        }
        /**caso a venda esteja fechada, ja atualizou o estoque.
        prrecisa de dovolver os produtos para o estoque*/
        $produtosvendidos = DB::table('detalhevendas as d')
            ->where('d.ce_venda', $id)->get();
        if($venda->st_status == 'Fechado'){
            return redirect()->back()->with('erroMsg', 'Venda/Orçamento Já está fechada, não pode ser cancelada.');
        }else{
           $vendacancelada = $venda->update([
                'st_status' =>'Cancelado',
           ]);
           if($vendacancelada){
               
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cancelou a venda/Orçaento de ID número: ' .$venda->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            return redirect()->back()->with('sucessoMsg', 'Operação realiazada com sucesso!'); 
           }else{
            return redirect()->back()->with('erroMsg', 'Erro ao realizar a operação solicitada.');
           }
        }

        $produtosvendidos = DB::table('detalhevendas as d')
            ->where('d.ce_venda', $id)->get();

            
    }
    public function fechar_venda(Request $request, $id)
    {
        $dadosForm = $request->all();
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = Venda::find($id);
        if( empty($venda)){
            return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!!');
        }
        //verificando se existe caixa aberto em nome do usuario que está tentando fechar a venda
        $caixaaberto = DB::table('caixas')->where([['ce_usuario', Auth::user()->id],['st_status', 'Aberto']])->first();
        if(empty($caixaaberto)){
            return redirect()->back()->with('erroMsg', 'Para fechar a venda é necessário o usuário está com um caixa aberto em seu nome.');
        }
        /**caso a venda esteja fechada, ja atualizou o estoque.
        prrecisa de dovolver os produtos para o estoque*/
        $produtosvendidos = DB::table('detalhevendas as d')
                                ->where('d.ce_venda', $id)
                                ->leftjoin('produtos as p', 'p.id', 'd.ce_produto')
                                ->select('d.*', 'p.st_descricao')
                                ->get();
                                
        if(count($produtosvendidos)< 1){

            return redirect()->back()->with('erroMsg', 'Não há produtos para esta venda. Ela deve ser cancelada ao invés de fechada.');
        }
        if($venda->st_status == 'Fechado'){
            return redirect()->back()->with('erroMsg', 'A venda Já está fechada, não pode ser cancelada.');
        }else if($venda->st_status != 'Concluído'){
            return redirect()->back()->with('erroMsg', 'Para Fachar a venda é necessário que ela esteja com status de Concluída.');
        }else{
            DB::beginTransaction();
            $vendafechada = $venda->update([
                'st_status' =>'Fechado',
                'st_forma_pagamento'=> $dadosForm['st_forma_pagamento'],
                'st_valor'=> $dadosForm['st_valor'],
                'dt_venda' => date('Y-m-d H:m:s'), 
                ]);
                foreach($produtosvendidos as $p){
                   
                  $produtoestoque = Produto::find($p->ce_produto);
                  $totalatualizado = $produtoestoque->nu_disponivel - $p->nu_quantidade;
                  if($totalatualizado >= 0 ){
                      $estoquealterado = $produtoestoque->update([
                        'nu_disponivel' =>$totalatualizado,
                        ]);
                  }else{

                    DB::rollback();        
                    return redirect()->back()->with('erroMsg', 'Não foi possível Fechar a venda, pois não tem '.$p->nu_quantidade .' '. $p->st_descricao. ' disponíveis no estoque.');  
                  }
                }
                //$adiciona no caixa 
                $adicionandonocaixa = Detalhescaixa::create([
                    'ce_caixa' => $caixaaberto->id,
                    'st_valor' => $dadosForm['st_valor'],
                    'ce_venda' => $id,
                    'st_tipomovimentacao' => 'Venda',
                ]);

                if($vendafechada &&  $estoquealterado){
                    /** Cadastra a ação na tabela log no banco. */
                    $acao = "Edição";
                    $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Fechou a venda de ID número: ' .$venda->id ;
                    /* Chamando a classe para registra a alteração na tabela logs. */
                    MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                    DB::commit();
                    return redirect()->back()->with('sucessoMsg', 'Venda Fechada com Sucesso.');
               }
               /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
                else{
                    DB::rollback();        
                    return redirect()->back()->with('erroMsg', 'Falha ao Fechar a venda');  
                }
        }
            
    }

    public function edit($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $venda = venda::find($id);
        if( $venda->st_status != 'Aberto'){
            return redirect()->back()->with('erroMsg', 'A venda não está aberta para edição!'); 
        }
       
        $vendedores = DB::table('users')->where('bo_ativo', 1)->orderby('name')->select('id', 'name')->get();
        $clientes = DB::table('clientes')->where('bo_ativo', 1)->orderby('st_nome')->select('id', 'st_nome')->get();
       
        return view('venda.Form_edita_venda', compact('venda', 'vendedores', 'clientes'));
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
            'dt_venda' => "required",
            'ce_vendedor' => "required",
            'ce_cliente' => "required",
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
        $venda = venda::find($id);
      
        if( $venda->st_status != 'Aberto'){
            return redirect()->back()->with('erroMsg', 'Esta venda não Está aberta para edição!'); 
        }
        /** Editando o compra de acordo com os dados do formulário */
        $vendaeditada = $venda->update($dadosForm); 

        /** Editando o compra */
        if($vendaeditada){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a venda/Orçaento de ID número: ' .$venda->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect('/venda/detalhe/'.$id)->with('sucessoMsg', 'Dados Atualizados com sucesso!'); 

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar o venda');  
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
        /** Busca na tabela o Venda a ser excluído */
        $compra = compra::find($id);
        /** Desativa ("deleta") o Venda setando o bo_ativo para 0 */
        
        $compraalterado = $compra->update([
            'bo_ativo' => 0
        ]);

        /** Cadastra a ação na tabela log no banco. */
        $acao = "Remoção";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o compra de ID número: ' .$compra->id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Redireciona para a listagem de vendas. */
        return redirect('/compras');
    }
    public function add_produto(Request $request, $idvenda)
    {
         $this->authorize('Administrador');
        /** Busca na tabela o compra a ser excluído */
        $venda = Venda::find($idvenda);
       
        if( $venda->st_status != 'Aberto'){
            return redirect()->back()->with('erroMsg',  'a Venda/Orçamento Não está aberta(o). Por isso, não é possível adicionar produto ela!'); 
        }
       // dd($request->all());
        $dadosform = $request->all();
       
        $produto = DB::table('produtos')->where('st_codigo',  $dadosform['st_codigo'])->first();
        if(empty($produto)){

            return redirect()->back()->with('erroMsg', 'Código do produto não encontrado!');
        }else if($produto->nu_disponivel <= 0){
            return redirect()->back()->with('erroMsg', 'Não há disponibilidade deste produto no estoque.'); 
        }else if($produto->nu_disponivel < $dadosform['nu_quantidade']){
            return redirect()->back()->with('erroMsg', 'Contamos apenas com '.$produto->nu_disponivel. ' unidade(s) no estoque.'); 
        }
        $produtosdavenda =  DB::table('detalhevendas')->where('ce_venda',  $idvenda)->get();
        
        if(count($produtosdavenda)>0){
            foreach($produtosdavenda as $p){

                if($p->ce_produto == $produto->id){
                    return redirect()->back()->with('erroMsg', 'Produto ja adicionado a lista!'); 
                }
            }
        }
        
        $insert = Detalhevenda::create([
            'ce_venda' => $idvenda,
            'ce_produto' => $produto->id,
            'nu_quantidade' => $dadosform['nu_quantidade'],
            ]);
            
            return redirect()->back()->with('sucessoMsg', 'Produto adicionado com sucesso!'); 
        }
        
        public function remove_detalhe(Request $request, $iddetalhecompra)
        {
            $this->authorize('Administrador');
            
            $produtodetalhe = Detalhevenda::find($iddetalhecompra);
            if(!empty($produtodetalhe)){
                $venda = Venda::find($produtodetalhe->ce_venda);
               if($venda->st_status == 'Finalizado'){

                   return redirect()->back()->with('erroMsg', 'Não é possível remover um produto de um da venda/orçamento finalizada!'); 
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
        public function concluir_venda( $idvenda)
        {
            $this->authorize('Administrador');
            
            $venda = Venda::find($idvenda);
            
            if(empty($venda)){
                return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!'); 
            }
            if($venda->st_status != 'Aberto'){
                return redirect()->back()->with('erroMsg', 'So é possível concluir a venda ou orçamento que está com aberto!'); 
            }

            $produtosvendidos = DB::table('detalhevendas')->where('ce_venda', $idvenda)->get();
            if(count($produtosvendidos) < 1){
                
                return redirect()->back()->with('erroMsg', 'Não há produtos para esta venda/orçamento. Por isso, essa operação deve ser cancelada ao invés de Concluída.'); 
            }

           $vendaconcluida = $venda->update([
                'st_status' => 'Concluído',
           ]);

           if($vendaconcluida){
            $acao = "Editou";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Concluiu venda de ID número: ' .$idvenda;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect()->back()->with('sucessoMsg', 'Dados atualizados com sucesso!');
           }
        
        }
        public function reabrir_venda( $idvenda)
        {
            $this->authorize('Administrador');
            
            $venda = Venda::find($idvenda);

            if(empty($venda)){
                return redirect()->back()->with('erroMsg', 'Venda/Orçamento não encontrada!'); 
            }
            if($venda->st_status == 'Aberto'){
                return redirect()->back()->with('erroMsg', 'Venda/Orçamento já está aberta'); 
            }

           $vendaaberta = $venda->update([
                'st_status' => 'Aberto',
           ]);

           if($vendaaberta){
            $acao = "Editou";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Reabriu venda de ID número: ' .$idvenda. ' para Edição.';
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect()->back()->with('sucessoMsg', 'Dados atualizados com sucesso!');
           }
        
        }
        public function editaprodutovenda(Request $request, $idproduto)
        {
            $this->authorize('Administrador');
            $dadosform =$request->all();

            $dadosform['st_desconto'] = str_replace(",",".", $dadosform['st_desconto']);
            if(empty($dadosform['st_desconto'])){
                $dadosform['st_desconto'] = '0.00';
            }


            $porduto = Detalhevenda::find( $idproduto);
          
            if(empty($porduto)){
                return redirect()->back()->with('erroMsg', 'Produto não encontrado!'); 
            }
            
            /**
             * resgatando os produtos da venda
             */
            $produtoatualizado =  $porduto->update([
                'nu_quantidade'=> $dadosform['nu_quantidade'],
                'st_desconto'=> $dadosform['st_desconto'],
                ]);
                if( $produtoatualizado){
                    
                    return redirect()->back()->with('sucessoMsg', 'Atualizado com sucesso!');
                }else{
                    
                    return redirect()->back()->with('erroMsg', 'Produto não Atualizado!'); 
            }
           
        }
        public function converte_orcamento_venda($idorcamento)
        {
            $this->authorize('Administrador');
            $orcamento = Venda::find($idorcamento);
          
            if(empty($orcamento)){
                return redirect()->back()->with('erroMsg', 'Orçãmento não encontrado!'); 
            }else if($orcamento->st_tipo != 'Orçamento'){
                return redirect()->back()->with('erroMsg', 'Erro ao converter. Isto não é um Orçamento!'); 

            }
            
            /**
             * convertendo o Orçamento em venda
             */
            $venda =  $orcamento->update([
                'st_tipo'=> 'Venda',
                ]);
                if( $venda){
                    
                    return redirect()->back()->with('sucessoMsg', 'Atualizado com sucesso!');
                }else{
                    
                    return redirect()->back()->with('erroMsg', 'Erro ao converter orçamento em venda!'); 
            }
           
        }
       
        public function vendasabertas($tipo)
        {
            $this->authorize('Administrador');
            $titulo = 'Vendas Abertas';
            if($tipo == 'orcamentos'){
                $tipo = "Orçamento";
                $titulo = 'Orçamentos Abertos';
            }
            $vendas = DB::table('vendas as v')->where([['v.st_status', 'Aberto'],['v.st_tipo', $tipo]])
                ->leftjoin('users as u', 'u.id', 'v.ce_vendedor') 
                ->leftjoin('clientes as c', 'c.id','v.ce_cliente' ) 
                ->select('V.*', 'c.st_nome as st_nome_cliente', 'u.name as st_nome_vendedor')
                ->orderby('dt_venda', 'desc')      
                ->paginate(30);
            
         
            if(empty($vendas)){
                return redirect()->back()->with('erroMsg', 'Não temos vendas abertas!'); 
            }
            
            return view('venda.Listavendas', compact('vendas', 'tipo', 'titulo'));
           
        }
       
}

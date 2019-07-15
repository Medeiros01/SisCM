<?php

namespace App\Http\Controllers;
use DB;
use App\Caixa;
use App\User;
use App\Detalhescaixa;
use App\Produto;
use App\utis\MyLog;
use Auth;
use PDF;

use Illuminate\Http\Request;


/**
 * Controller da caixa (dbo.caixa)
 */
class CaixaController extends Controller
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
     
            $caixas = DB::table('caixas as c')
                        ->leftjoin('users as u','u.id', 'c.ce_usuario')
                        ->select('c.*', 'u.name as st_nome_usuario')
                        ->orderby('c.st_status', 'asc')
                        ->orderby('c.dt_abertura', 'desc')
                        ->paginate(30);
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou os caixas abertos.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos caixas. */
        return view('caixa.Listacaixas', compact('caixas'));
    }
    public function caixasabertos(Request $request)
    {
     
            $caixas = DB::table('caixas as c')
                        ->where([['c.st_status', 'Aberto'],['c.ce_usuario', Auth::user()->id]])
                        ->leftjoin('users as u','u.id', 'c.ce_usuario')
                        ->select('c.*', 'u.name as st_nome_usuario')
                        ->get();
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou os caixas abertos.';
        /* Chamando a classe para registrar a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Retorna a listagem dos caixas. */
        return view('caixa.Listacaixasabertos', compact('caixas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Administrador');

        $caixas = DB::table('caixas as c')
        ->where([['c.st_status', 'Aberto'],['c.ce_usuario', Auth::user()->id]])
        ->leftjoin('users as u','u.id', 'c.ce_usuario')
        ->get();
        $caixasabertos = count($caixas);
        if($caixasabertos > 0){
            return redirect()->back()->with('erroMsg', 'Exite '. $caixasabertos. ' caixa(s) aberto(s) em nome deste usuário. Para abrir um novo é necessário fechar o existente!!');
        }else{
            DB:: beginTransaction();
            
            $insert = Caixa::create([
                'ce_usuario' => Auth::user()->id,
            ]) ;
            /** Tentando inserir o caixa no banco */
            if($insert){
                DB::commit();
                /** Cadastra a ação na tabela log no banco. */
                $acao = "Cadastro";
                $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Abriu o caixa de ID número: ' .$insert->id ;
                /* Chamando a classe para registra a alteração na tabela logs. */
                MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
    
                /** Redirecionando para o index de caixas. */
                return redirect('/caixasabertos');
            }
            /**
             * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
             */
            else{
                DB::rollback();
                return redirect()->back()->with('erroMsg', 'Falha ao abrir o caixa');  
            }

        }

        return view('caixa.Form_cad_caixa', compact('fornecedores', 'categorias'));         
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
        $dadosForm['st_valor_caixa'] = str_replace(".","", $dadosForm['st_valor_caixa']);
        $dadosForm['st_valor_caixa'] = str_replace(",",".", $dadosForm['st_valor_caixa']);
        $dadosForm['ce_usuario'] = $usuario;
        
        /** Inserindo a caixa */
        $insert = caixa::create($dadosForm) ;
        /** Tentando inserir o caixa no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou o caixa de ID número: ' .$insert->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para o index de caixas. */
            return redirect('/caixas');
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o caixa');  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detalhe($idcaixa)
    {
        
       
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        
        $caixa = DB::table('caixas as c')->where('c.id', $idcaixa)
                        ->leftjoin('users', 'users.id', 'c.ce_usuario')
                        ->select('c.*', 'users.name as nomedoresponsavel')
                        ->first();
      
            $vendas = DB::table('detalhescaixas as d')
                                    ->where([['d.ce_caixa', $idcaixa],['d.st_tipomovimentacao', 'Venda']])
                                    ->leftjoin('vendas as v', 'v.id', 'd.ce_venda')
                                    ->leftjoin('users as u', 'u.id', 'v.ce_vendedor')
                                    ->select('d.*', 'v.ce_vendedor', 'v.st_forma_pagamento', 'v.nu_codigo', 'v.dt_cadastro as dt_cadastrovenda', 'u.name as nomevendedor')
                                    ->get(); 
            $vendasdinheiro = null;
            $vendascheque = null;
            $vendascartao = null;
            $vendascarne = null;
            foreach( $vendas as $v){
                if($v->st_forma_pagamento == 'Dinheiro'){
                    $vendasdinheiro[] = $v;

                }else if($v->st_forma_pagamento == 'Cheque'){
                    $vendascheque[] = $v;
                }else if($v->st_forma_pagamento == 'Cartão'){
                    $vendascartao[] = $v;
                }else{
                    $vendascarne[] = $v;
                }
            }
            $outrasentradas = DB::table('detalhescaixas as d')
            ->where([['d.ce_caixa', $idcaixa],['d.st_tipomovimentacao', 'Entrada']])
            ->get(); 
            $saidas = DB::table('detalhescaixas as d')
            ->where([['d.ce_caixa', $idcaixa],['d.st_tipomovimentacao', 'Saida']])
            ->get(); 
                
           
      /*  return response()->json('1'); */
        return view('caixa.Detalhecaixa', compact('caixa', 'vendasdinheiro', 'vendascartao', 'vendascheque', 'vendascarne', 'outrasentradas', 'saidas'));
    }
    public function show($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $caixa = DB::table('caixas as c')->where([['c.bo_ativo', 1],['c.id', $id]])
                    ->leftjoin('fornecedores as f', 'c.ce_fornecedor', 'f.id')
                    ->select('c.*', 'f.st_nome as st_nome_fornecedor')
                    ->first();
        if( empty($caixa)){
            return redirect()->back()->with('erroMsg', 'caixa não encontrada!!');
        }
        
        return view('caixa.Detalhecaixa', compact('caixa'));
    }

    public function edit($id)
    {
        $this->authorize('Administrador');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $caixa = caixa::find($id);
        if( $caixa->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'O estoque já foi atualizado com esta caixa. Por isso, não é possivel fazer alteração em seus dados!'); 
        }
       
        $fornecedores = DB::table('fornecedores')->where('bo_ativo', 1)->get();

        return view('caixa.Form_edita_caixa', compact('caixa', 'fornecedores'));
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
        $dadosForm['st_valor_caixa'] = str_replace(".","", $dadosForm['st_valor_caixa']);
        $dadosForm['st_valor_caixa'] = str_replace(",",".", $dadosForm['st_valor_caixa']);
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'dt_caixa' => "required",
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
        /** Buscando na tabela o caixa que será editado */
        $caixa = caixa::find($id);
        if( $caixa->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'O estoque já foi atualizado com esta caixa. Por isso, não é possivel fazer alteração em seus dados!'); 
        }
        /** Editando o caixa de acordo com os dados do formulário */
        $caixaeditada = $caixa->update($dadosForm); 

        /** Editando o caixa */
        if($caixaeditada){
            DB::commit();

            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a caixa de ID número: ' .$caixa->id ;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            /** Redirecionando para a listagem de caixas */
            return redirect('/caixas')->with('sucessoMsg', 'Dados Atualizados com sucesso!'); 

           }
           /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
            else{
                DB::rollback();        
                return redirect()->back()->with('erroMsg', 'Falha ao Alterar o caixa');  
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
        /** Busca na tabela o caixa a ser excluído */
        $caixa = caixa::find($id);
        /** Desativa ("deleta") o caixa setando o bo_ativo para 0 */
        
        $caixaalterado = $caixa->update([
            'bo_ativo' => 0
        ]);

        /** Cadastra a ação na tabela log no banco. */
        $acao = "Remoção";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o caixa de ID número: ' .$caixa->id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        /** Redireciona para a listagem de caixas. */
        return redirect('/caixas');
    }
    public function add_produto(Request $request, $idcaixa)
    {
         $this->authorize('Administrador');
        /** Busca na tabela o caixa a ser excluído */
        $caixa = caixa::find($idcaixa);
        if( $caixa->bo_atualizouestoque == 1){
            return redirect()->back()->with('erroMsg', 'Esta caixa já foi finalizada. Por isso, não é possível adicionar produto a caixa!'); 
        }
       // dd($request->all());
        $dadosform = $request->all();
       
        $produto = DB::table('produtos')->where('st_codigo',  $dadosform['st_codigo'])->first();
        if(empty($produto)){
            return redirect()->back()->with('erroMsg', 'Código do produto não encontrado!'); 
        }
        $produtosdacaixa =  DB::table('detalhecaixas')->where('ce_caixa',  $idcaixa)->get();
        
        if(count($produtosdacaixa)>0){
            foreach($produtosdacaixa as $p){
                if($p->ce_produto == $produto->id){
                    return redirect()->back()->with('erroMsg', 'Produto ja adicionado a lista de caixa!'); 
                }
            }
        }
        $dadosform['st_preco_custo'] = str_replace(".","", $dadosform['st_preco_custo']);
        $dadosform['st_preco_custo'] = str_replace(",",".", $dadosform['st_preco_custo']);
        $dadosform['st_preco_venda'] = str_replace(".","", $dadosform['st_preco_venda']);
        $dadosform['st_preco_venda'] = str_replace(",",".", $dadosform['st_preco_venda']);
        $insert = Detalhescaixa::create([
            'ce_caixa' => $idcaixa,
            'ce_produto' => $produto->id,
            'nu_quantidade' => $dadosform['nu_quantidade'],
            'st_preco_custo' => $dadosform['st_preco_custo'],
            'st_preco_venda' => $dadosform['st_preco_venda'],
            ]);
            
            /** Redireciona para a detalhe da caixa. */
            return redirect()->back()->with('sucessoMsg', 'Produto adicionado com sucesso!'); 
        }
        
        public function remove_detalhe(Request $request, $iddetalhecaixa)
        {
            $this->authorize('Administrador');
            
            $produtodetalhe = Detalhescaixa::find($iddetalhecaixa);
            if(!empty($produtodetalhe)){
                $caixa = caixa::find($produtodetalhe->ce_caixa);
               if($caixa->bo_atualizouestoque == 1){

                   return redirect()->back()->with('erroMsg', 'Não é possível remover um produto de um caixa finalizada!'); 
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
        public function fachar_caixa( $idcaixa)
        {
            $this->authorize('Administrador');
            
            $caixa = Caixa::find( $idcaixa);
           
            if(empty($caixa)){
               
                return redirect()->back()->with('erroMsg', 'Caixa não encontrado!'); 
            }else if($caixa->st_status == 'Fechado'){
                return redirect()->back()->with('erroMsg', 'O caixa que você esta tentando fechar já está fechado!'); 
            }else if($caixa->ce_usuario != Auth::user()->id){
                return redirect()->back()->with('erroMsg', 'O Caixa só pode ser fechado pelo seu responsável!'); 
            }
           // dd($caixa->status);
            
            /**
             * fechando o caixa
             */

            $caixaatualizado =  $caixa->update([
                'dt_finalizado'=> date('Y-m-d H:m:s'),
                'st_status'=> 'Fechado',
                ]);
            
           if($caixaatualizado){
                 /** Cadastra a ação na tabela log no banco. */
                $acao = "update";      
                $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'fechou o caixa de id: '.$caixa->id.'.';
                /* Chamando a classe para registrar a alteração na tabela logs. */
                MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
             /**caRedirecionando para a listagem de caixas */
             return redirect()->back()->with('sucessoMsg', 'Caixa fechado com sucesso!');     
            }else{
                return redirect()->back()->with('erroMsg', 'Erro ao Fechar o caixa!'); 
            }
        }
        public function form_cad_saida_valores()
        {
            $this->authorize('Administrador');
            $caixaaberto = DB::table('caixas')->where([['ce_usuario', Auth::user()->id],['st_status', 'Aberto']])->first();
           
            if(empty($caixaaberto)){
                return redirect()->back()->with('erroMsg', 'Para cadastrar uma Saída de valor é necessário um caixa aberto em seu nome!');   
            }
           return view('caixa.Form_cad_saida_valores');
        }
        public function form_cad_entrada_valores()
        {
            $this->authorize('Administrador');
            $caixaaberto = DB::table('caixas')->where([['ce_usuario', Auth::user()->id],['st_status', 'Aberto']])->first();
           
            if(empty($caixaaberto)){
                return redirect()->back()->with('erroMsg', 'Para cadastrar uma entrada de valor é necessário um caixa aberto em seu nome!');   
            }
           return view('caixa.Form_cad_entrada_valores');
        }
        public function cad_saida_valores(Request $request)
        {
            $this->authorize('Administrador');
            $caixaaberto = DB::table('caixas')->where([['ce_usuario', Auth::user()->id],['st_status', 'Aberto']])->first();
           
            if(empty($caixaaberto)){
                return redirect()->back()->with('erroMsg', 'Para cadastrar uma Sáida de valor é necessário um caixa aberto em seu nome!');   
            }
            $dadosform = $request->all(); 

            $validator = validator($dadosform, [
                'st_valor' => 'required',       
                'st_descricao' => 'required|max:255',
                'st_forma_pagamento' => 'required',

                ]);
            
            /** Se a validação falhar, mensagens de erro serão exibidas. */
            if($validator->fails()){
               
                return redirect()->back()
                /** Mensagem de Erro */         
                    ->withErrors($validator)
               /** Preenchendo o Formulário */         
                    ->withInput();
            }
            $dadosform['st_valor'] = str_replace(",",".", $dadosform['st_valor']);
            $dadosform['st_valor'] = str_replace(".","", $dadosform['st_valor']);
            
            $insert = Detalhescaixa::create([
                'ce_caixa' => $caixaaberto->id,
                'st_valor' => $dadosform['st_valor'],
                'st_tipomovimentacao' => 'Saida',
                'st_forma_pagamento' => $dadosform['st_forma_pagamento'],
                'st_descricao' => $dadosform['st_descricao'],
            ]);
            
            if( $insert){
                  /** Cadastra a ação na tabela log no banco. */
                  $acao = "Insert";      
                  $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Cadastrou manualmente uma Saída de valor no caixa de id: '.$caixaaberto->id.', no valor de :'.$dadosform['st_valor'].'.';
                  /* Chamando a classe para registrar a alteração na tabela logs. */
                  MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                  return redirect('caixa/detalhe/'.$caixaaberto->id);
            }else{
                return redirect()->back()->with('erroMsg', 'Erro ao realziar o cadastro!');   
            }
            
           
        }
        public function cad_entrada_valores(Request $request)
        {
            $this->authorize('Administrador');
            $caixaaberto = DB::table('caixas')->where([['ce_usuario', Auth::user()->id],['st_status', 'Aberto']])->first();
           
            if(empty($caixaaberto)){
                return redirect()->back()->with('erroMsg', 'Para cadastrar uma entrada de valor é necessário um caixa aberto em seu nome!');   
            }
            $dadosform = $request->all(); 

            $validator = validator($dadosform, [
                'st_valor' => 'required',       
                'st_descricao' => 'required|max:255',
                'st_forma_pagamento' => 'required',

                ]);
            
            /** Se a validação falhar, mensagens de erro serão exibidas. */
            if($validator->fails()){
               
                return redirect()->back()
                /** Mensagem de Erro */         
                    ->withErrors($validator)
               /** Preenchendo o Formulário */         
                    ->withInput();
            }
            $dadosform['st_valor'] = str_replace(",",".", $dadosform['st_valor']);
            $dadosform['st_valor'] = str_replace(".","", $dadosform['st_valor']);
            
            $insert = Detalhescaixa::create([
                'ce_caixa' => $caixaaberto->id,
                'st_valor' => $dadosform['st_valor'],
                'st_tipomovimentacao' => 'Entrada',
                'st_forma_pagamento' => $dadosform['st_forma_pagamento'],
                'st_descricao' => $dadosform['st_descricao'],
            ]);
            
            if( $insert){
                  /** Cadastra a ação na tabela log no banco. */
                  $acao = "Insert";      
                  $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Cadastrou manualmente uma entrada de valor no caixa de id: '.$caixaaberto->id.', no valor de :'.$dadosform['st_valor'].'.';
                  /* Chamando a classe para registrar a alteração na tabela logs. */
                  MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                  return redirect('caixa/detalhe/'.$caixaaberto->id);
            }else{
                return redirect()->back()->with('erroMsg', 'Erro ao realziar o cadastro!');   
            }
            
           
        }
        public function editaoutrasentradas(Request $request, $iddetalhecaixa)
        {
            $this->authorize('Administrador');
            $dadosform = $request->all();
           
            $detalhecaixa = Detalhescaixa::find($iddetalhecaixa);
           
           
            if(empty($detalhecaixa)){
                return redirect()->back()->with('erroMsg', "Registro não encontrado.");   
            }
           

            $validator = validator($dadosform, [
                'st_valor' => 'required',       
                'st_descricao' => 'required|max:255',
                'st_forma_pagamento' => 'required',

                ]);
            
            /** Se a validação falhar, mensagens de erro serão exibidas. */
            if($validator->fails()){
               
                return redirect()->back()
                /** Mensagem de Erro */         
                    ->withErrors($validator)
               /** Preenchendo o Formulário */         
                    ->withInput();
            }
            $dadosform['st_valor'] = str_replace(",",".", $dadosform['st_valor']);
            $dadosform['st_valor'] = str_replace(".","", $dadosform['st_valor']);
            
            $update = $detalhecaixa->update([
                'st_forma_pagamento' => $dadosform['st_forma_pagamento'],
                'st_descricao' => $dadosform['st_descricao'],
                'st_valor' => $dadosform['st_valor'],
            ]);
            
            if( $update){
                  /** Cadastra a ação na tabela log no banco. */
                  $acao = "update";      
                  $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Editou entrada de valor no caixa de id: '.$detalhecaixa->id.', no valor de :'.$dadosform['st_valor'].'.';
                  /* Chamando a classe para registrar a alteração na tabela logs. */
                  MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                  return redirect()->back()->with('sucessoMsg', 'Dados Atualizados com sucesso!'); 
            }else{
                return redirect()->back()->with('erroMsg', 'Erro ao realziar o cadastro!');   
            }
            
           
        }
       
}

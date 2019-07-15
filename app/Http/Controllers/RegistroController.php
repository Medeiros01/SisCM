<?php

namespace App\Http\Controllers;
use DB;
use DateTime;
use App\Registro;
use App\TipoRegistro;
use App\Funcionario;
use App\Orgao;
use App\Cr;
use App\Item;
use App\User;
use App\utis\MyLog;
use Auth;
use Illuminate\Http\Request;

class RegistroController extends Controller
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
    //Lista todos os registros dos  usuarios ativos do sistema
    public function listaregistro($funcionario)
    {
    
        
       /*  $orgao = DB::select(
            DB:: raw("SELECT o.st_sigla, COUNT(f.id) AS qtde
            FROM funcionarios AS f 
            LEFT JOIN orgaos AS o ON f.ce_orgao = o.id
            WHERE o.bo_ativo = 1 and f.bo_ativo = 1
            GROUP BY o.st_sigla
            ORDER BY o.st_sigla ASC")
        ); */
       
        
        $this->authorize('Admin');
        $registros = DB::table('crs')->where([['crs.ce_funcionario', $funcionario],['crs.bo_ativo', 1]])
        ->leftJoin('tiposregistro', 'tiposregistro.id', 'crs.ce_tiporegistro' )
        ->select('crs.*', 'tiposregistro.st_tipo')
        ->orderby('crs.dt_registro', 'Desc')
        ->get();
       

        $acao = "Consulta";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a Caderneta de Reguistro do funcionario de id: '.$funcionario;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        return 'Este método realiza a conulta de registro por servidor. Falta redirecionar para a view de editar sevidor.';
    }

    //lista todos as Crs por tipo e por servidor
    public function listacrportipo($funcionario, $tiporegsitro, $listagemouimpressao)
    {
        $this->authorize('Edita');

        $servidor = Funcionario::find($funcionario);
            if(empty($servidor)){
                return redirect()->back()->with('erroMsg', 'O Funcionário para que você está tentando exisbir os dados não existe em nosso banco de dados.');  
            }
        $itenstiporegistro = DB::table('itens')->where([['itens.bo_ativo', 1],['itens.ce_tiporegistro',  $tiporegsitro]])
        ->leftjoin('tiposregistro', 'tiposregistro.id', 'itens.ce_tiporegistro')
        ->orderby('itens.nu_sequencia_form')
        ->get();
        //caso não exista o t
        if( $itenstiporegistro->count()<=0){
            return redirect()->back()->with('erroMsg', 'Não existe publicação do tipo expecificado.');  
        }
        
        $cr = DB::table('crs')->where([['crs.bo_ativo', 1],['crs.ce_funcionario',$funcionario ],['crs.ce_tiporegistro',  $tiporegsitro]])
        ->leftjoin('tiposregistro', 'tiposregistro.id', 'crs.ce_tiporegistro')
        ->orderby('crs.dt_registro', 'desc')
        ->select('crs.id', 'tiposregistro.st_tipo as st_tiporegistro')
        ->get();
 

        if(isset($cr) && count($cr)>0){
            foreach($cr as $c){
                $campos = DB::table('registros')->where('registros.ce_crs',  $c->id)
                ->leftjoin('itens', 'registros.ce_item', 'itens.id')
                ->leftjoin('tipositens', 'tipositens.id', 'itens.ce_tipoitem')
                ->select('registros.*', 'tipositens.st_item as tipoitem', 'itens.st_nome as st_nomedoitem')
                ->get();
               
                $c->registros = $campos->toArray();
                $registros[] = $c;
            }
            
        }else{
        
           // return redirect()->back()->with('erroMsg', 'Não existe publicação do tipo '.$itenstiporegistro[0]->st_tipo. ' para este servidor.');
        }   
       if($listagemouimpressao == 'impressao'){

           $acao = "Impressão";
           $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Imprimiu a Caderneta de regsitro em geral ';
           /* Chamando a classe para registra a alteração na tabela logs. */
           MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
   
           return \PDF::loadView('pdf.Pdflistaregistrosservidor', compact('registros','servidor', 'funcionario', 'tiporegsitro', 'itenstiporegistro'))
           // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
            ->stream('nome-arquivo-pdf-gerado.pdf');
       }else{
        $acao = "Consulta";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a Caderneta de regsitro em geral ';
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
       // return view('ferias.Listadados', compact('registros', 'servidor', 'tiporegsitro', 'itenstiporegistro'));
       return view('ferias.Listaregistrosservidor', compact('registros', 'servidor', 'funcionario', 'tiporegsitro', 'itenstiporegistro'));
       }

    }





    //MODELO DE LISTAGEM
    public function modelolistagem($funcionario, $tiporegsitro)
    {
        $this->authorize('Admin');
        $registros = DB::table('crs')->where([['crs.bo_ativo', 1],['crs.ce_funcionario',$funcionario ],['crs.ce_tiporegistro',  $tiporegsitro]])
        ->leftJoin('tiposregistro', 'tiposregistro.id', 'crs.ce_tiporegistro' )
        ->leftJoin('funcionarios', 'crs.ce_funcionario', 'funcionarios.id')
        ->select('crs.*', 'tiposregistro.st_tipo', 'funcionarios.st_nome')

        ->orderby('crs.dt_registro', 'Desc')
        ->get();

        $acao = "Consulta";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a Caderneta de regsitro em geral ';
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        return view('ferias.Listaferiasservidor', compact('registros'));
    }



    //MODELO DE LISTAGEM
    public function editaferias(Request $requens, $funcionario, $regsitro)
    {
        $editacampo = null;
        $this->authorize('Edita');
        $dadosform = $requens->all();
        foreach($dadosform as $key => $dado){
            if($key != '_token'){
                $editacampo = Registro::find($key);
               
                $editacampo ->update([
                    'st_valor' =>$dado
                ]);
                   
               
            }

        }
        return redirect()->back()->with('sucessoMsg', 'Registro realizado com sucesso.'); 


        $ditacampo = Registro::find(1);
        $registros = DB::table('crs')->where([['crs.bo_ativo', 1],['crs.ce_funcionario',$funcionario ],['crs.ce_tiporegistro',  $tiporegsitro]])
        ->leftJoin('tiposregistro', 'tiposregistro.id', 'crs.ce_tiporegistro' )
        ->leftJoin('funcionarios', 'crs.ce_funcionario', 'funcionarios.id')
        ->select('crs.*', 'tiposregistro.st_tipo', 'funcionarios.st_nome')

        ->orderby('crs.dt_registro', 'Desc')
        ->get();

        $acao = "Consulta";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a Caderneta de regsitro em geral ';
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        return view('ferias.Listaferiasservidor', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       
        
    }

   

    
    public function store(Request $request, $idfuncionario, $tiporegistro)
    {
        $this->authorize('Edita');
       
        $dadosform = $request->all();
        $funcionario = Funcionario::find($idfuncionario);
      
       
        DB:: beginTransaction();

      
         try{
 
             $insertcr = Cr::create([
                'dt_registro' => Date('Y-d-m h:i:s'),
                'ce_tiporegistro' => $tiporegistro,
                'ce_funcionario' => $idfuncionario,
                'ce_setor' => $funcionario->ce_setor,
                'bo_ativo' => 1
               ]) ;
              
               foreach ($dadosform as $key => $value) {
                 
                    if(($key != "_token") && ($key != "st_status") && ($key != "st_alterastatus") && ($key != "st_desativafuncionario") && ($key != "st_motivo")){
                     

                        $insertregritro = Registro::create([
                            'dt_registro' => Date('Y-d-m h:i:s'),
                            'ce_item' =>  $key,
                            'st_valor' => $value,
                            'ce_crs' =>$insertcr->id
             
                            ]) ;
                    }else if($key == "st_alterastatus" && $value == "Sim")
                    {   
                       //$func = Funcionario::find($funcionario);
                       if(!empty($funcionario)){
                           $funcionario->update([
                            'ce_status' => $dadosform['st_status'],
                        ]);
                       }
                    }else if($key == "st_desativafuncionario" && $value == "Sim")
                    {   
                        
                       //$func = Funcionario::find($funcionario);
                       if(!empty($funcionario)){
                        
                           $funcionario->update([
                            'bo_ativo' => '0',
                            'st_tipoinatividade' => $dadosform['st_motivo'],
                        ]);
                       }
                    }
                }
               
                $acao = "Cadastro";
                $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou uma caderneta de registro: ' .$insertcr->id;
                /* Chamando a classe para registra a alteração na tabela logs. */
                MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                DB::commit();
                //return redirect()->route('listacrportipo/'.$idfuncionario.'/'.$$idfuncionari)->with('sucessoMsg', 'Registro realizado com sucesso.'); 
                return redirect()->route('listacrportipo', [$idfuncionario, $tiporegistro, 'listagem'])->with('sucessoMsg', 'Registro realizado com sucesso.'); 
               
               
               
               
               
                return redirect()->route('listacrportipo/'.$idfuncionario.'/'.$tiporegistro)->with('sucessoMsg', 'Registro realizado com sucesso.'); 
                return redirect()->back()->with('sucessoMsg', 'Registro realizado com sucesso.'); 
                
         }catch(Exception $e){
            DB::rollback();
            //   return 'Falha ao Cadastrar os Dados!';
            return redirect()->back()->with('erroMsg', 'Falha ao Realizar o Registro.');  

    }  
     
           }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($usuario, $tiporegistro )
    {
        $this->authorize('Edita');
    
        /***
         * Resgatando do itens do tipo do geristro do tipo geregistro geral
         */
         $itens = DB::table('itens')->where([['itens.ce_tiporegistro', $tiporegistro],['itens.bo_ativo', 1]])
                    ->leftJoin('tipositens', 'tipositens.id', 'itens.ce_tipoitem' )
                    ->select('itens.*', 'tipositens.st_item as st_nomeitem')
                    ->orderby('itens.nu_sequencia_form')
                    ->get();
         $status = DB::table('statusfuncoes')->where('statusfuncoes.bo_ativo', 1)
                    ->orderby('statusfuncoes.st_status')
                    ->get();
                   
         $funcionario = DB::table('funcionarios')->where('id', $usuario)->first();
        
      
    
         return view('registro.Form_cad_registro', compact('itens', 'funcionario', 'tiporegistro', 'status'));
         
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcao = DB::table('funcoes')->where('id',  $id)->orderby('st_funcao')->first();

        //pegando todos os perfis de usuário para popular o campo perfil   
        return view('funcao.Form_edita_funcao', compact('funcao'));
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
        DB::beginTransaction();
        $dadosForm = $request->all();

        $validator = validator($dadosForm, [
            'st_funcao' => "required|max:150|unique:funcoes,st_funcao,$id",
        ]);

        if($validator->fails()){
           
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        $funcao = Funcao::find($id);
        $funcaoeditada = $funcao->update($dadosForm);

        if($funcaoeditada){
            DB::commit();

            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a funcao de ID número: ' .$funcao->id;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect('/funcoes');
            //Redirecionando para mostrar o resumo do documento cadastrado
            //return view('comele.Resumo_documento', compact('documento','examesCadastrados'));
            //return "1";
           }else{
               DB::rollback();
            //return 'Falha ao Cadastrar os Dados!';
            
            return redirect()->back()->with('erroMsg', 'Falha ao Alterar a função');  
   
           }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyferias($id)
    {
        //verifica se o usuário tem a permissão de excluir o registro
        $this->authorize('Admin');
        //recupera a caderneta de registro com o id passado como parâmetro
        $cr = Cr::find($id);
        //caso o id seja de registro ativo, permite realizar exclusão 
        if(!empty($cr)){
            if($cr->bo_ativo = 1){
                
                //abre a transaction
                DB::beginTransaction();

                //desativa o registro
                $crdeletada = $cr->update([
                    'bo_ativo' => 0
                ]);
                //prepara para salvar no log    
                $acao = "Remoção";
                $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Deletou a Cr de id: ' .$cr->id;
                /* Chamando a classe para registra a alteração na tabela logs. */
                MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                $cadastrolog = true;
                
                //valida se desativou o registro e cadatrou no log. Caso tenha ocorrido tudo conforme o esperado, comita, fecha a transaction, e redireciona para a lista de registros
                if(isset($crdeletada) && isset($cadastrolog)){
                    DB::commit();
                return redirect()->back()->with('sucessoMsg', 'Registro excluído com sucesso.'); 
                }else{
                   // Caso dê algo errado desfaz toda a operação, fecha a transaction, e redireciona para a lista de registros
                    DB::rollback();
                    return redirect()->back()->with('erroMsg', 'Falha ao Excluir o Registro.');  
        
                }

            }else{
                //caso o bo_ativo seja difente de 1 e exista o registro, é pq ele ja foi excluído anteriormente
                return redirect()->back()->with('erroMsg', 'O registro que você está querendo excluir já foi deletado anteriormente.'); 
            }

         //caso o id não seja de registro ativo, redicionar para pagina anterior informando que não existe o registro
        }else{
            return redirect()->back()->with('erroMsg', 'O registro que você está querendo excluir não existe.'); 
        }
       
        
        
    }
  
    
}

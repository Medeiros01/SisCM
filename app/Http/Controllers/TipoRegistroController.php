<?php

namespace App\Http\Controllers;
use DB;
use App\TipoRegistro;
use App\utis\MyLog;
use Auth;
use Illuminate\Http\Request;

class TipoRegistroController extends Controller
{

    //Lista todos os tipos de registro do sistema
    public function index()
    {
        $this->authorize('Admin');
        //Seleciona os tipo de registros ativos do sistema
        $tiposregistro = TipoRegistro::where('bo_ativo',  '1')
        ->orderby('st_tipo')->get();

        /***** CRIANDO LOGS NO SISTEMA *****/
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou os tipos de registros';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        /***** CRIANDO LOGS NO SISTEMA *****/
       
       return view('tiporegistro.Listatiporegistro', compact('tiposregistro')); 
    }

    //Chama o formulário de cadastro de tipos de registro
    public function form_tiporegistro()
    {
        //Retornando a view de cadastro de tipos de registro
        return view('tiporegistro.Form_cad_tiporegistro'); 
    }

    //Chama o formulário de edição de tipos de registro
    public function form_edita($id)
    {
        //Selecionando o tipo de registro que está ativo
        $tiporegistro = TipoRegistro::where('id', $id)->where('bo_ativo', '1')->first();
        return view('tiporegistro.Form_edita_tiporegistro', compact('tiporegistro'));
    }

    //realizar o cadastro dos tipos de registro
    public function cad_tiporegistro(Request $request)
    {
        //recebendo os dados do formulário
        $dadosForm = $request->all();
        //validando os dados
        $validator = validator($dadosForm, [
            'st_tipo' => 'required|max:50',
            'st_descricao' => 'required|max:300'
        ]);
    
        //atribuindo bo_ativo = 1 para os usuarios cadastrados
        $dadosForm['bo_ativo'] = 1;
      
        if($validator->fails())
        {
            return redirect()->back()
            //Mensagem de Erro
            ->withErrors($validator)
            //Preenchendo o Formulário
            ->withInput();
        }
        //Inserindo um tipo de registro
        $insert = TipoRegistro::create($dadosForm) ;
        
        if($insert)
        {
            /***** CRIANDO LOGS NO SISTEMA *****/
            $acao = "Cadastro";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' criou o tipo de registro.';
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            /***** CRIANDO LOGS NO SISTEMA *****/

            //Se deu certo, redireciona para tela de listagem de tipos de registro
            return redirect('/tiporegistros')->with('sucessoMsg', 'Tipo de registro cadastrado com sucesso!');
        }else
        {
            return redirect()->back()->with('erroMsg', 'Falha ao cadastrar o tipo de registro');
        }
        
    }

    public function update(Request $request, $id)
    {
       
        //recebendo os dados do formulário
        $dadosForm = $request->all();
        //validando os dados
        $validator = validator($dadosForm, [
            'st_tipo' => 'required|max:50',
            'st_descricao' => 'required|max:300'
        ]);
    
        if($validator->fails())
        {
            return redirect()->back()
            //Mensagem de Erro
            ->withErrors($validator)
            //Preenchendo o Formulário
            ->withInput();
        }

        $tiporegistro = TipoRegistro::find($id);
        
        //Atualizando tipo de registro
        $update = $tiporegistro->update($dadosForm) ;

        if($update)
        {
            /***** CRIANDO LOGS NO SISTEMA *****/
            $acao = "Edição";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou o tipo de registro.';
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            /***** CRIANDO LOGS NO SISTEMA *****/

            //Se deu certo, redireciona para tela de listagem de tipos de registro
            return redirect('/tiporegistros')->with('sucessoMsg', 'Tipo de registro alterado com sucesso!');
        }else
        {
            return redirect()->back()->with('erroMsg', 'Falha ao atualizar tipo de registro');
        }  
    }

    public function desativa($id)
    {
        //pegando todos os perfis de usuário para popular o campo perfil
        $tiporegistro = TipoRegistro::find($id);

        $desativado = $tiporegistro->update([ "bo_ativo" => 0 ]);

        if($desativado)
        {
            /***** CRIANDO LOGS NO SISTEMA *****/
            $acao = "Remoção";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o tipo de registro.';
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            /***** CRIANDO LOGS NO SISTEMA *****/

            //Se deu certo, redireciona para tela de listagem de tipos de registro
            return redirect('/tiporegistros')->with('sucessoMsg', 'Tipo de registro removido com sucesso!');
        }else
        {
            return redirect()->back()->with('erroMsg', 'Falha ao remover tipo de registro');
        }  
    }

}

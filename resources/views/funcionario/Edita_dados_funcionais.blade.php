@extends('funcionario.Form_edita_funcionario')

@section('tabcontent')
<div class="tab-pane active" id="dados_funcionais">
    <h4 class="tab-title">Dados Funcionais - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Informações de identificação</legend>
            <div class="row">
                <!-- <div class="form-group{{ $errors->has('st_nomeguerra') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nomeguerra">Nome de guerra</label>
                    <input id="st_nomeguerra" type="text" class="form-control" placeholder="Digite o nome" name="st_nomeguerra" value="{{ $servidor->st_nomeguerra }}"> 
                    @if ($errors->has('st_nomeguerra'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nomeguerra') }}</strong>
                    </span>
                    @endif
                </div> -->
                <div class="form-group{{ $errors->has('st_matricula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_matricula">Matrícula</label>
                    <input id="st_matricula" type="text" class="form-control" placeholder="Digite a matricula" name="st_matricula" value="{{ $servidor->st_matricula }}"> 
                    @if ($errors->has('st_matricula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_matricula') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('ce_graduacao') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_graduacao" class="control-label">Posto/Graduação</label>
                    <select id="ce_graduacao" name="ce_graduacao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($graduacoes as $g)
                            <option value="{{$g->id}}"  {{( $g->id == $servidor->ce_graduacao) ? 'selected': '' }}>{{$g->st_postograduacao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_graduacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ce_graduacao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_nivel') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nivel" class="control-label">Nivel</label>
                    <select id="st_nivel" name="st_nivel" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        <option {{ $servidor->st_nivel == 'N/A' ? 'selected':''}} value="N/A">N/A</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="1">1</option>
                        <option {{ $servidor->st_nivel == '2' ? 'selected':''}} value="2">2</option>
                        <option {{ $servidor->st_nivel == '3' ? 'selected':''}} value="3">3</option>
                        <option {{ $servidor->st_nivel == '4' ? 'selected':''}} value="4">4</option>
                        <option {{ $servidor->st_nivel == '5' ? 'selected':''}} value="5">5</option>
                        <option {{ $servidor->st_nivel == '6' ? 'selected':''}} value="6">6</option>
                        <option {{ $servidor->st_nivel == '7' ? 'selected':''}} value="7">7</option>
                        <option {{ $servidor->st_nivel == '8' ? 'selected':''}} value="8">8</option>
                        <option {{ $servidor->st_nivel == '9' ? 'selected':''}} value="9">9</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="10">10</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="11">11</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="12">12</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="13">13</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="14">14</option>
                        <option {{ $servidor->st_nivel == '1' ? 'selected':''}} value="15">15</option>
                    </select>
                    @if ($errors->has('st_nivel'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nivel') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('ce_orgao') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_orgao" class="control-label">Orgão de origem</label>
                    <select id="ce_orgao" name="ce_orgao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($orgaos as $o)
                            <option value="{{$o->id}}" {{( $o->id == $servidor->ce_orgao) ? 'selected': '' }}>{{$o->st_sigla}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_orgao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ce_orgao') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
    
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Informações da nomeação</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_tipoinclusao') ? ' has-error' : '' }} col-md-2">
                    <label for="st_tipoinclusao" class="control-label">Inclusão por</label>
                    <select id="st_tipoinclusao" name="st_tipoinclusao" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        <option value="Incorporação" {{ $servidor->st_tipoinclusao == 'Incorporação' ? 'selected':''}}>Incorporação</option>
                        <option value="Ato governamental" {{ $servidor->st_tipoinclusao == 'Ato governamental' ? 'selected':''}}>Ato governamental</option>
                        <option value="Contrato de trabalho" {{ $servidor->st_tipoinclusao == 'Contrato de trabalho' ? 'selected':''}}>Contrato de trabalho</option>
                        <option value="Portaria" {{ $servidor->st_tipoinclusao == 'Portaria' ? 'selected':''}}>Portaria</option>
                        <option value="Boletim geral" {{ $servidor->st_tipoinclusao == 'Boletim geral' ? 'selected':''}}>Boletim geral</option>
                        <option value="Memorando" {{ $servidor->st_tipoinclusao == 'Memorando' ? 'selected':''}}>Memorando</option>
                        <option value="Oficio" {{ $servidor->st_tipoinclusao == 'Oficio' ? 'selected':''}}>Oficio</option>
                    </select>
                    @if ($errors->has('st_tipoinclusao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tipoinclusao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_numerodocumentoposse') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numerodocumentoposse" class="control-label">Nº Doc</label>
                    <input id="st_numerodocumentoposse" type="text" class="form-control" name="st_numerodocumentoposse" value="{{ $servidor->st_numerodocumentoposse }}"> 
                    @if ($errors->has('st_numerodocumentoposse'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numerodocumentoposse') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_doe') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_doe" class="control-label">DOE</label>
                    <input id="dt_doe" type="date" class="form-control" name="dt_doe" value="{{ $servidor->dt_doe }}"> 
                    @if ($errors->has('dt_doe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_doe') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_posse') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_posse" class="control-label">Data da posse</label>
                    <input id="dt_posse" type="date" class="form-control" name="dt_posse" value="{{ $servidor->dt_posse }}"> 
                    @if ($errors->has('dt_posse'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_posse') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_nomeacao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nomeacao" class="control-label">Data da nomeação</label>
                    <input id="dt_nomeacao" type="date" class="form-control" name="dt_nomeacao" value="{{ $servidor->dt_nomeacao }}"> 
                    @if ($errors->has('dt_nomeacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_nomeacao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_exercissio') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_exercissio" class="control-label">Exercício</label>
                    <input id="dt_exercissio" type="date" class="form-control" name="dt_exercissio" value="{{ $servidor->dt_exercissio }}"> 
                    @if ($errors->has('dt_exercissio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_exercissio') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Informações de inclusão na SESED</legend>
            <div class="form-group{{ $errors->has('dt_inclusao') ? ' has-error' : '' }} col-md-3">
                <label for="dt_inclusao" class="control-label">Data de inclusão</label>
                <input id="dt_inclusao" type="date" class="form-control" name="dt_inclusao" value="{{ $servidor->dt_inclusao }}"> 
                @if ($errors->has('dt_inclusao'))
                <span class="help-block">
                    <strong>{{ $errors->first('dt_inclusao') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('ce_cargo') ? ' has-error' : '' }} col-md-3">
                <label for="ce_cargo" class="control-label">Cargo</label>
                <select id="ce_cargo" name="ce_cargo" class="form-control" style="width: 100%;">
                    <option value="" selected>Selecione</option>
                    @forelse($cargos as $c)
                        <option value="{{$c->id}}" {{( $c->id == $servidor->ce_cargo) ? 'selected': '' }}>{{$c->st_cargo}}</option>
                    @empty
                        <option>Não há cargos cadastrados.</option>
                    @endforelse
                </select>
                @if ($errors->has('ce_cargo'))
                <span class="help-block">
                    <strong>{{ $errors->first('ce_cargo') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('st_folha') ? ' has-error' : '' }} col-md-2">
                <label for="st_folha" class="control-label">Folha</label>
                <select id="st_folha" name="st_folha" class="form-control" style="width: 100%;">
                    <option value=""  selected>Selecione</option>
                    <option {{ $servidor->st_folha == '101' ? 'selected':''}} value="101">101</option>
                    <option {{ $servidor->st_folha == '102' ? 'selected':''}} value="102">102 SESED</option>
                    <option {{ $servidor->st_folha == '103' ? 'selected':''}} value="103">103 SESAP – SAUDE</option>
                    <option {{ $servidor->st_folha == '104' ? 'selected':''}} value="104">104</option>
                    <option {{ $servidor->st_folha == '105' ? 'selected':''}} value="105">105 GAC</option>
                    <option {{ $servidor->st_folha == '106' ? 'selected':''}} value="106">106</option>
                    <option {{ $servidor->st_folha == '107' ? 'selected':''}} value="107">107</option>
                    <option {{ $servidor->st_folha == '108' ? 'selected':''}} value="108">108</option>
                    <option {{ $servidor->st_folha == '109' ? 'selected':''}} value="109">109 SEJUC</option>
                    <option {{ $servidor->st_folha == '110' ? 'selected':''}} value="110">110</option>
                    <option {{ $servidor->st_folha == '111' ? 'selected':''}} value="111">111 POLICIA CIVIL</option>
                    <option {{ $servidor->st_folha == '112' ? 'selected':''}} value="112">112 ITEP</option>
                    <option {{ $servidor->st_folha == '113' ? 'selected':''}} value="113">113</option>
                    <option {{ $servidor->st_folha == '114' ? 'selected':''}} value="114">114 POLICIA MILITAR</option>
                    <option {{ $servidor->st_folha == '115' ? 'selected':''}} value="115">115 SEC. EDUCAÇÃO</option>
                    <option {{ $servidor->st_folha == '116' ? 'selected':''}} value="116">116 APOSENTADO</option>
                    <option {{ $servidor->st_folha == '117' ? 'selected':''}} value="117">117</option>
                    <option {{ $servidor->st_folha == '132' ? 'selected':''}} value="132">132 CORPO DE BOMBEIROS</option>
                </select>
                @if ($errors->has('st_folha'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_folha') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('ce_gratificacao') ? ' has-error' : '' }} col-md-3">
                <label for="ce_gratificacao" class="control-label">Gratificação</label>
                <select id="ce_gratificacao" name="ce_gratificacao" class="form-control" style="width: 100%;">
                    <option value="" selected>Selecione</option>
                    @forelse($gratificacoes as $g)
                        <option value="{{$g->id}}" {{( $g->id == $servidor->ce_gratificacao) ? 'selected': '' }}>{{$g->st_gratificacao}}</option>
                    @empty
                        <option>Não há gratificações cadastrados.</option>
                    @endforelse
                </select>
                @if ($errors->has('ce_gratificacao'))
                <span class="help-block">
                    <strong>{{ $errors->first('ce_gratificacao') }}</strong>
                </span>
                @endif
            </div>
        </fieldset>

        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Informações do setor</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('ce_setor') ? ' has-error' : '' }} col-md-3">
                    <label for="ce_setor" class="control-label">Setor</label>
                    <select id="ce_setor" name="ce_setor" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($setores as $s)
                            <option value="{{$s->id}}" {{( $s->id == $servidor->ce_setor) ? 'selected': '' }}>{{$s->st_sigla}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_setor'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ce_setor') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('ce_funcao') ? ' has-error' : '' }} col-md-3">
                    <label for="ce_funcao" class="control-label">Função</label>
                    <select id="ce_funcao" name="ce_funcao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($funcoes as $f)
                            <option value="{{$f->id}}" {{( $f->id == $servidor->ce_funcao) ? 'selected': '' }}>{{$f->st_funcao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_funcao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ce_funcao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('ce_status') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_status" class="control-label">Situação</label>
                    <select id="ce_status" name="ce_status" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        @if(isset( $status ) && count( $status )>0)
                            @foreach( $status as $key => $valor)
                            @if( $valor->id ==   $servidor->ce_status )
                           
                            <option value="{{ $valor->id}}" selected = "true">{{$valor->st_status}}</option>
                            @else
                            <option value="{{ $valor->id}}">{{$valor->st_status}}</option>
                            @endif
                            @endforeach
                        @endif
                       
                    </select>
                    @if ($errors->has('ce_status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ce_status') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_horariotrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_horariotrabalho" class="control-label">Horário de trabalho</label>
                    <select id="st_horariotrabalho" name="st_horariotrabalho" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        <option {{ $servidor->st_horariotrabalho == 'MANHÃ' ? 'selected':''}} value="MANHÃ">MANHÃ</option>
                        <option {{ $servidor->st_horariotrabalho == 'TARDE' ? 'selected':''}} value="TARDE">TARDE</option>
                        <option {{ $servidor->st_horariotrabalho == 'NOITE' ? 'selected':''}} value="NOITE">NOITE</option>
                        <option {{ $servidor->st_horariotrabalho == 'MANHÃ E TARDE' ? 'selected':''}} value="MANHÃ E TARDE">MANHÃ E TARDE</option>
                        <option {{ $servidor->st_horariotrabalho == 'OUTRO' ? 'selected':''}} value="OUTRO">OUTRO</option>
                    </select>
                    @if ($errors->has('st_horariotrabalho'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_horariotrabalho') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_devolucao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_devolucao" class="control-label">Data de devolução</label>
                    <input id="dt_devolucao" type="date" class="form-control" name="dt_devolucao" value="{{ $servidor->dt_devolucao }}" required> 
                    @if ($errors->has('dt_devolucao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_devolucao') }}</strong>
                    </span>
                    @endif
                </div>
                <!-- <div class="form-group{{ $errors->has('bo_ativo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_ativo" class="control-label">Status</label>
                    <select id="bo_ativo" name="bo_ativo" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        <option {{ $servidor->bo_ativo == '1' ? 'selected':''}} value="1" >ATIVO</option>
                        <option {{ $servidor->bo_ativo == '0' ? 'selected':''}} value="0">INATIVO</option>
                    </select>
                    @if ($errors->has('bo_ativo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_ativo') }}</strong>
                    </span>
                    @endif
                </div> -->
                <!-- <div class="form-group{{ $errors->has('st_tipoinatividade') ? ' has-error' : '' }} col-md-3">
                    <label for="st_tipoinatividade" class="control-label">Motivo</label>
                    <select id="st_tipoinatividade" name="st_tipoinatividade" class="form-control" style="width: 100%;">
                        <option value=""  selected>Selecione</option>
                        <option {{ $servidor->st_tipoinatividade == 'ABANDONO DE CARGO' ? 'selected':''}} value="ABANDONO DE CARGO">ABANDONO DE CARGO</option>
                        <option {{ $servidor->st_tipoinatividade == 'APOSENTADO' ? 'selected':''}} value="APOSENTADO">APOSENTADO</option>
                        <option {{ $servidor->st_tipoinatividade == 'EXONERADO' ? 'selected':''}} value="EXONERADO">EXONERADO</option>
                        <option {{ $servidor->st_tipoinatividade == 'DEVOLVIDO' ? 'selected':''}} value="DEVOLVIDO">DEVOLVIDO</option>
                        <option {{ $servidor->st_tipoinatividade == 'DEMITIDO' ? 'selected':''}} value="DEMITIDO">DEMITIDO</option>
                        <option {{ $servidor->st_tipoinatividade == 'FALECIDO' ? 'selected':''}} value="FALECIDO">FALECIDO</option>
                        <option {{ $servidor->st_tipoinatividade == 'RELOTADO' ? 'selected':''}} value="RELOTADO">RELOTADO</option>
                        <option {{ $servidor->st_tipoinatividade == 'OUTROS' ? 'selected':''}} value="OUTROS">OUTROS</option>
                    </select>
                    @if ($errors->has('st_tipoinatividade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tipoinatividade') }}</strong>
                    </span>
                    @endif
                </div> -->
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-offset-5">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
    </form>
</div>
<!-- /.tab-pane -->
@endsection
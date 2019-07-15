
@extends('adminlte::page')

@section('title', 'Lista de Servidor')
@can('Edita')
    @section('content_header')
    
    <div class="row">
        <div class="col-md-1">
            <a class="btn btn-primary  pull-left" href="{{url('servidor/create')}}">Novo Servidor</a>
        </div>
        @if(isset($status))
            <div class="col-md-10">
                
                <form id="listaFuncionarioFilter" class="form-inline pull-left"  role="form" method="POST" action='{{ url("servidores/" .$status. "/listagem/") }}'>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input id="st_tipo" type="hidden"  name="st_tipo" value="{{$st_tipo or 'null'}}"> 
                        <div class="col-md-2">
                            <select id="filterlist" name="filterlist" required="true" class="form-control" onclick="selectFilterFuncionarios()">
                                <option value="">Selecione</option>
                                <option value="ce_setor">Setor</option>
                                <option value="ce_orgao">Órgão</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="divSetorFilter" class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }}" style="display: none">
                            <div class="col-md-2">
                                <select id="st_sigla" name="st_valor" required="true" class="form-control" disabled="true" onclick="selectFilterFuncionarios()">
                                    <option value="">Selecione o Setor</option>
                                    @if(isset($listSetor)&& count($listSetor)>0)
                                    @foreach($listSetor as $s)
                                    <option value="{{$s->id}}">{{$s->st_sigla}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('st_sigla'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_sigla') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="divOrgaoFilter" class="form-group{{ $errors->has('st_orgao') ? ' has-error' : '' }}" style="display: none">
                            <div class="col-md-2">
                                <select id="st_orgao" name="st_valor" required="true" class="form-control" disabled="true" onclick="selectFilterFuncionarios()">
                                    <option value="">Selecione o Órgão</option>
                                    @if(isset($listOrgao)&& count($listOrgao)>0)
                                    @foreach($listOrgao as $o)
                                    <option value="{{$o->id}}">{{$o->st_orgao}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('st_orgao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_orgao') }}</strong>
                                </span>
                                @endif
                            </div>                                                     
                        </div>
                        
                    </div>
                    <button type="submit" onclick="selecionatipoexportacao('listagem')" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        @endif
    </div>
    @stop
@endcan

@section('content')
        <div class="row">
            <div class="col-md-13">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="4">{{$nome_tabela}}</th> 
                            <th>
                                @can('Edita')
                                    @if(isset($status))
                                        <div class="col-md-1">
                                            <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("servidores/".$status."/execel/") }}'>
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Lista Excel</button>

                                                <input  type="hidden"  name="filterlist" value="{{$filterlist or 'null'}}"> 
                                                <input type="hidden"  name="st_valor" value="{{$st_valor or 'null'}}"> 
                                                                                            
                                            </form>
                                        </div>
                                    @endif
                                @endcan
                            </th>
                            <th>
                                    @can('Edita')
                                        @if(isset($status) )
                                            <div class="col-md-1">
                                                <form id="listaFuncionarioFilter" class="form-horizontal" role="form" method="POST" action='{{ url("servidores/".$status."/pdf/") }}'>
                                                    {{csrf_field()}}
                                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>
        
                                                    <input  type="hidden"  name="filterlist" value="{{$filterlist or 'null'}}"> 
                                                    <input type="hidden"  name="st_valor" value="{{$st_valor or 'null'}}"> 
                                                                                                
                                                </form>
                                            </div>                              
                                        @endif
                                    @endcan
                                </th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-2">CPF</th>
                            <th class="col-md-2">ORGÃO</th>
                            <th class="col-md-2">SETOR</th>
                            @can('Admin')
                            <th class="col-md-3">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($servidores))
                            @forelse($servidores as $s)
                            <tr>
                                <th>{{$s->st_nome}}</th>
                                <th>{{$s->st_matricula}}</th>
                                <th>{{$s->st_cpf}}</th>
                                <th>{{$s->st_siglaorgao}}</th>
                                <th>{{$s->st_siglasetor}}</th>
                                <th>
                                    @can('Edita')
                                    <a class="btn btn-primary" href="{{url('servidor/edita/'.$s->id.'/dados_pessoais')}}">Editar</a>
                                    @endcan
                                    @if($s->bo_ativo == 0)
                                    @can('Edita')
                                    <a onclick="modalAtiva({{$s->id}})" data-toggle="modal" data-placement="top" class="btn btn-primary" >Ativar</a>
                                    @endcan
                                    @endif
                                    @can('Consulta_ficha')
                                    <a class="btn btn-primary" href="{{url('servidor/imprimirficha/'.$s->id)}}"><i class="fa fa-fw fa-print"></i>Ficha</a>
                                    @endcan  
                                </th>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum servidor encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ativar Servidor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-inline" id="modalAtiva" method="post" > {{csrf_field()}}
                    <div class="modal-body bg-danger">
                        <h4 class="modal-title" id="exampleModalLabel">
                            <b>DESEJA REALMENTE ATIVAR O SERVIDOR?</b>
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Ativar</button>
                    </div>
                </form>
            </div>
        </div>
   
    <script>
        function modalAtiva(id){
            $("#modalAtiva").attr("action", "{{ url('servidor/ativa')}}/"+id);
            $('#Modal').modal();        
        };
    </script>


@stop
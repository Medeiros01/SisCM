@extends('adminlte::page')

@section('title', 'Listegem')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
                <div class="caixa">
                    <div class="col-md-4">
                        @if($tipo == "Venda")
                            <a href="{{url("venda/create/Venda")}}" class="btn btn-primary">NOVA VENDA</a>
                        @elseif($tipo == "Orçamento")
                            <a href="{{url("venda/create/orcamento")}}" class="btn btn-primary">NOVO ORÇAMENTO</a>
                        @endif
                    </div>
                    <div class="col-md-8">
                
                            <form id="buscavenda" class="form-inline pull-left"  role="form" method="POST" action='{{ url("vendas") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" required="required" name="st_venda" id="st_venda" class="form-control" placeholder="NOME OU CÓDIGO DO venda">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                            
                            </form>

                    </div>
                </div>

               {{--  Começa a exibição do vendas --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-striped table-hover colapse">
                        <thead>
                            <tr class="bg-primary">
                                
                                @if($tipo == 'Venda')
                                    <th colspan="6">LISTAGEM DE VENDA ABERTAS</th>
                                @elseif($tipo == 'Orçamento')
                                    <th colspan="6">LISTAGEM DE ORÇAMENTOS ABERTOS</th>
                                @endif
                               
                            </tr>
                            <tr>
                                <th class="col-md-1 ">Data</th>
                                <th class="col-md-1 ">Código</th>
                                <th class="col-md-2">Cliente</th>
                                <th class="col-md-2">Vendedor</th>
                                <th class="col-md-2">Situação</th>
                                @can('Administrador')
                               
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($vendas) && count($vendas)>0)
                            @foreach($vendas as $v)
                                <tr style="font-size:12px" >
                                    <th>{{date('d/m/Y', strtotime($v->dt_venda))}}</th>
                                    <th>{{$v->nu_codigo}}{{date('dmY', strtotime($v->dt_cadastro))}}</th>
                                    <th>{{$v->st_nome_cliente}}</th>
                                    <th>{{$v->st_nome_vendedor}}</th>
                                    <th>{{$v->st_status}}</th>
                                {{--  <th>{{str_replace(".",",", $v->ce_vendedor)}}</th> --}}
                                    @can('Administrador')
                                        @if($v->st_status == 'Aberto')
                                            <th ><a href="{{url('venda/edita/'.$v->id)}}" title="Editar"> <i class="fa fa-pencil"></i> Editar</a> 
                                            <a href="{{url('venda/detalhe/'.$v->id)}}" title="Detalhar"> <i class="glyphicon glyphicon-info-sign btn-xs"></i> Detalhar</a></th> 
                                        @else
                                            <th  ><a href="{{url('venda/detalhe/'.$v->id)}}" title="Detalhar"> <i class="glyphicon glyphicon-info-sign btn-xs"></i> Detalhar</a> </th>

                                        @endif
                                    @endcan
                                </tr>
                            @endforeach
                        @else
                            <tr><th colspan="5" class="bg-danger"> Não há Registros</th></tr>
                        @endif
                    </tbody>

                </table>
                {{$vendas->links()}}
            </div>
        </div>
    </div>
 
@stop
@extends('adminlte::page')

@section('title', 'compras')

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
                            <a href="{{url("compra/create")}}" class="btn btn-primary">NOVO COMPRA</a>
                
                    </div>
                    <div class="col-md-8">
                
                            <form id="buscacompra" class="form-inline pull-left"  role="form" method="POST" action='{{ url("compras") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <select class="form-control" name="st_campo" id="st_campo">
                                            <option value="">Selecione um parâmetro para busca</option>
                                            <option value="st_notafiscal">Código da Compra</option>
                                            <option value="dt_periodo">Período</option>
                                            <option value="ce_fornecedor">Fornecedor</option>
                                        </select>
                                       
                                </div>
                                <div class="input-group fornecedor" style="display: none">
                                        <select class="form-control" id="ce_fornecedor" name="ce_fornecedor">
                                            <option value="">Selecione o nome do fornecedor</option>
                                            @if(isset($fornecedores) && count($fornecedores)>0)
                                                @foreach($fornecedores as $f)
                                                <option value="{{$f->id}}">{{$f->st_nome}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                       
                                </div>
                                <div class="input-group valor">
                                        <input type="text"  name="st_valor" id="st_valor" class="form-control">
                                        
                                </div>
                                <div class="input-group periodo" style="display: none">
                                        <input type="date" id="dt_compra_inicio"  name="dt_compra_inicio" id="dt_compra_inicio" >
                                        <input type="date" id="dt_compra_fim" name="dt_compra_fim" id="dt_compra_fim" >
                                        
                                </div>
                                <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                </div>
                            
                            </form>

                    </div>
                </div>

               {{--  Começa a exibição do compras --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="3">LISTAGEM DE COMPRAS</th>
                                <th colspan="2">
                                    @if(isset($compras) && count($compras)> 0)
                                    Total de compras ativos: {{count($compras)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th class="col-md-1 ">Nata Fiscal</th>
                                <th class="col-md-2">Data da Compra</th>
                                <th class="col-md-2">Fornecedor</th>
                                <th class="col-md-2">Valor da Compra</th>
                                @can('Administrador')
                               
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($compras))
                            @foreach($compras as $c)
                        <tr style="font-size:12px" >
                            <th>{{$c->st_notafiscal}}</th>
                            <th>{{date('d/m/Y', strtotime($c->dt_compra))}}</th>
                            <th>{{$c->st_nome_fornecedor}}</th>
                            <th>{{str_replace(".",",", $c->st_valor_compra)}}</th>
                            @can('Administrador')
                            @if($c->bo_atualizouestoque != 1)
                            <th ><a href="{{url('compra/edita/'.$c->id)}}" title="Editar"> <i class="fa fa-pencil"></i> Editar</a> 
                            <a href="{{url('compra/detalhe/'.$c->id)}}" title="Detalhar"> <i class="glyphicon glyphicon-info-sign btn-xs"></i> Detalhar</a></th> 
                            @else
                            <th  ><a href="{{url('compra/detalhe/'.$c->id)}}" title="Detalhar"> <i class="glyphicon glyphicon-info-sign btn-xs"></i> Detalhar</a> </th>
                           

                            @endif


                            @endcan
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{$compras->appends(['st_valor' => $valor, 'ce_fornecedor' =>$fornecedor, 'dt_compra_inicio' => $datainicio, 'dt_compra_fim' => $datafim, 'st_campo' =>$campo])->links()}}
            </div>
        </div>
    </div>
 
@stop
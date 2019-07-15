@extends('adminlte::page')

@section('title', 'Produtos')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
                <div class="caixa">
                    @can('cad_produtos')
                    <div class="col-md-4">
                            <a href="{{url("produto/create")}}" class="btn btn-primary">NOVO PRODUTO</a>
                    </div>
                    @endcan
                    <div class="col-md-8">
                
                            <form id="buscaproduto" class="form-inline pull-left"  role="form" method="POST" action='{{ url("produtos") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" required="required" name="st_produto" id="st_produto" class="form-control" placeholder="NOME OU CÓDIGO DO PRODUTO">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                            
                            </form>

                    </div>
                </div>

               {{--  Começa a exibição do produtos --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="5">LISTAGEM DE PRODUTOS</th>
                                <th colspan="4">
                                    @if(isset($produtos) && count($produtos)> 0)
                                    Total de Produtos ativos: {{count($produtos)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th class="col-md-1 ">CÓDIGO</th>
                                <th class="col-md-2">NOME</th>
                                <th class="col-md-2">DESCRIÇÃO</th>
                                <th class="col-md-1">FORNECEDOR</th>
                                <th class="col-md-2">CATEGORIA</th>
                                <th class="col-md-1">QUANTIDADE</th>
                                @can('cad_produtos')
                                <th class="col-md-1">PREÇO CUSTO</th>
                                @endcan
                                <th class="col-md-1">PREÇO VENDA</th>
                                @can('cad_produtos')
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($produtos))
                            @foreach($produtos as $c)
                        <tr style="font-size:12px" >
                            <th>{{$c->st_codigo}}</th>
                            <th>{{$c->st_nome}}</th>
                            <th>{{$c->st_descricao}}</th>
                            <th>{{$c->st_nome_fornecedor}}</th>
                            <th>{{$c->st_nome_categoria}}</th>
                            <th>{{$c->nu_disponivel}}</th>
                            @can('cad_produtos')
                            <th>{{str_replace(".",",",$c->st_preco_custo)}}</th>
                            @endcan
                            <th>{{str_replace(".",",",$c->st_preco_venda)}}</th>
                            @can('cad_produtos')
                            <th class="redirect" onclick='location.href = "{{url('produto/edita/'.$c->id)}}";' ><a href="{{url('produto/edita/'.$c->id)}}" title="Editar"> <i class="fa fa-pencil"></i> Editar</a> 
                            </th>
                            @endcan
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $produtos->appends(['st_produto' => $st_produto])->links() }}

@stop
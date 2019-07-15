@extends('adminlte::page')

@section('title', 'Clientes')

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
                            <a href="{{url("cliente/create")}}" class="btn btn-primary">NOVO CLIENTE</a>
                
                    </div>
                    <div class="col-md-8">
                
                            <form id="buscacliente" class="form-inline pull-left"  role="form" method="POST" action='{{ url("clientes") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" required="required" name="st_cliente" id="st_cliente" class="form-control" placeholder="NOME, CPF OU RG">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                            
                            </form>

                    </div>
                </div>

               {{--  Começa a exibição do clientes --}}
        
                <div class="col-md-12">
                    

                    <table class=" table table-bordered table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="3">LISTAGEM DE CLIENTES</th>
                                <th colspan="3">
                                    @if(isset($clientes) && count($clientes)> 0)
                                    Total de Clientes ativos: {{count($clientes)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th class="col-md-3">NOME</th>
                                <th class="col-md-1">CPF</th>
                                <th class="col-md-1">RG</th>
                                <th class="col-md-3">Endereço</th>
                                <th class="col-md-3">Município</th>
                                @can('Administrador')
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($clientes))
                            @foreach($clientes as $c)
                        <tr style="font-size:12px">
                            <th>{{$c->st_nome}}</th>
                            <th>{{$c->st_cpf}}</th>
                            <th>{{$c->st_rg}}</th>
                            <th>{{$c->st_endereco}}</th>
                            @if(!empty($c->st_municipio))
                            <th>{{$c->st_municipio}}/{{$c->st_estado}}</th>
                            @else
                            <th></th>
                            @endif
                            @can('Administrador')
                            <th onclick='location.href = "{{url('cliente/edita/'.$c->id)}}";' ><a href="{{url('cliente/edita/'.$c->id)}}" title="Editar"> <i class="fa fa-pencil"></i></a> 
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

 
@stop
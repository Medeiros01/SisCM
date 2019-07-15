@extends('adminlte::page')

@section('title', 'Editar de vendas')

@section('content')
<div class="row">
        <div class="col-md-12">
            
                @if(session('sucessoMsg'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso!</strong> {{ session('sucessoMsg')}}
                    </div>
                </div>
                @endif
                @if(session('erroMsg'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Atenção!</strong> {{ session('erroMsg')}}
                    </div>
                </div>
                @endif
        </div>
    </div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Editar venda</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/venda/edita/'.$venda->id) }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('dt_venda') ? ' has-error' : '' }}">
                        <label for="dt_venda" class="col-md-4 control-label">Data da Venda</label>

                        <div class="col-md-6">
                            <input id="dt_venda" type="date" class="form-control" required="true" name="dt_venda" value="{{ date('Y-m-d',strtotime( $venda->dt_venda)) }}"> 
                            @if ($errors->has('dt_venda'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dt_venda') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
         
                    <div class="form-group{{ $errors->has('ce_cliente') ? ' has-error' : '' }}">
                        <label for="ce_cliente" class="col-md-4 control-label">Cliente</label>
                        <div class="col-md-6">
                            <select id="ce_cliente" name="ce_cliente" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($clientes) && count($clientes)>0 )
                                    @foreach($clientes as $c)
                                        @if($venda->ce_cliente == $c->id)
                                        <option selected="true" value="{{$c->id}}">{{$c->st_nome}}</option>
                                        @else
                                        <option value="{{$c->id}}">{{$c->st_nome}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_cliente'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_cliente') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
 
         
                    <div class="form-group{{ $errors->has('ce_vendedor') ? ' has-error' : '' }}">
                        <label for="ce_vendedor" class="col-md-4 control-label">Vendedor</label>
                        <div class="col-md-6">
                            <select id="ce_vendedor" name="ce_vendedor" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($vendedores) && count($vendedores)>0 )
                                    @foreach($vendedores as $v)
                                        @if($venda->ce_vendedor == $v->id)
                                        <option selected="true" value="{{$v->id}}">{{$v->name}}</option>
                                        @else
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_vendedor'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_vendedor') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

    

                

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ URL::previous() }}' class=" btn btn-danger"  title="Voltar">
                                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                            </a>
                        </div>
                        <button type="submit" class="col-md-2 btn btn-primary">
                            <i class="fa fa-check"> </i> Salvar
                        </button>
                    </div>


                </form>
                
                
            </div>
        </div>
</div>
@stop
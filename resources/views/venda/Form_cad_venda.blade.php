@extends('adminlte::page')

@section('title', 'Cadastro de vendas')

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
            <div class="panel-heading">Novo(a) {{$tipo}}</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/venda') }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('st_notafiscal') ? ' has-error' : '' }}">
                        <label for="st_notafiscal" class="col-md-4 control-label">N° da Nota Fiscal</label>

                        <div class="col-md-6">
                            <input id="st_notafiscal" type="text" class="form-control" required="true" placeholder="Insira o n° da nota Fiscal" name="st_notafiscal" value="{{ old('st_notafiscal') }}"> 
                            @if ($errors->has('st_notafiscal'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_notafiscal') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                  
                            <input id="st_tipo" type="hidden" name="st_tipo" value="{{$tipo}}"> 
                           
 
         
                    <div class="form-group{{ $errors->has('ce_vendedor') ? ' has-error' : '' }}">
                        <label for="ce_vendedor" class="col-md-4 control-label">Fornecedor</label>
                        <div class="col-md-6">
                            <select id="ce_vendedor" name="ce_vendedor" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($vendedores) && count($vendedores)>0 )
                                    @foreach($vendedores as $v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
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

                    <div class="form-group{{ $errors->has('st_valor_venda') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Valor da venda</label>
    
                            <div class="col-md-6">
                                <input id="st_valor_venda" type="money" class="form-control" required="true" placeholder="Insira o valor da venda"  name="st_valor_venda" > 
                                @if ($errors->has('st_valor_venda'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_valor_venda') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>

                

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("vendas")}}' class=" btn btn-danger"  title="Voltar">
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
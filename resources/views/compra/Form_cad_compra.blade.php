@extends('adminlte::page')

@section('title', 'Cadastro de compras')

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
            <div class="panel-heading">Cadastro de Compra</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/compra') }}">
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
                    <div class="form-group{{ $errors->has('dt_compra') ? ' has-error' : '' }}">
                        <label for="dt_compra" class="col-md-4 control-label">Data da Compra</label>

                        <div class="col-md-6">
                            <input id="dt_compra" type="date" class="form-control" required="true" name="dt_compra" value="{{ old('dt_compra') }}"> 
                            @if ($errors->has('dt_compra'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dt_compra') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
 
         
                    <div class="form-group{{ $errors->has('ce_fornecedor') ? ' has-error' : '' }}">
                        <label for="ce_fornecedor" class="col-md-4 control-label">Fornecedor</label>
                        <div class="col-md-6">
                            <select id="ce_fornecedor" name="ce_fornecedor" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($fornecedores) && count($fornecedores)>0 )
                                    @foreach($fornecedores as $f)
                                        <option value="{{$f->id}}">{{$f->st_nome}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_fornecedor'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_fornecedor') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_valor_compra') ? ' has-error' : '' }}">
                            <label for="st_nome" class="col-md-4 control-label">Valor da Compra</label>
    
                            <div class="col-md-6">
                                <input id="st_valor_compra" type="money" class="form-control" required="true" placeholder="Insira o valor da compra"  name="st_valor_compra" > 
                                @if ($errors->has('st_valor_compra'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_valor_compra') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>

                

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("compras")}}' class=" btn btn-danger"  title="Voltar">
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
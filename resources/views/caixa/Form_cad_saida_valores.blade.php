@extends('adminlte::page')

@section('title', 'Cadastrar Saída ')

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
            <div class="panel-heading">Cadastro de Saída de Valores</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('caixa/cad_saida_valores') }}">
                    {{ csrf_field() }}
                 

                    <div class="form-group{{ $errors->has('st_forma_pagamento') ? ' has-error' : '' }}">
                        <label for="st_forma_pagamento" class="col-md-4 control-label">Tipo de Saída</label>
                        <div class="col-md-6">
                            <select id="st_forma_pagamento" name="st_forma_pagamento" class="form-control" required="required">
                                <option value="">Selecione</option>
                                <option  value="Dinheiro">Dinheiro</option>
                                <option  value="Cartão">Cartão</option>
                                <option  value="Carnê">Carnê</option>
                                <option  value="Cheque">Cheque</option>
                                
                            </select>
                            @if ($errors->has('st_forma_pagamento'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_forma_pagamento') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_valor') ? ' has-error' : '' }}">
                        <label for="st_valor" class="col-md-4 control-label">Valor</label>

                        <div class="col-md-6">
                            <input id="st_valor" type="money" class="form-control"   name="st_valor" value="{{ old('st_valor') }}"> 
                            @if ($errors->has('st_valor'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_valor') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                        <label for="st_descricao" class="col-md-4 control-label">Decrição</label>

                        <div class="col-md-6">
                            <input id="st_descricao" type="text" class="form-control"  placeholder="Informe a origem do valor" name="st_descricao" value="{{ old('st_descricao') }}"> 
                            @if ($errors->has('st_descricao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_descricao') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                  

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("/")}}' class=" btn btn-danger"  title="Voltar">
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
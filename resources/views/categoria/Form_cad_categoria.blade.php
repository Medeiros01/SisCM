@extends('adminlte::page')

@section('title', 'Cadastro de Categorias')

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
            <div class="panel-heading">Cadastro de Categoria</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/categoria') }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-4 control-label">Nome</label>

                        <div class="col-md-6">
                            <input id="st_nome" type="text" class="form-control" required="true" placeholder="Insira o Nome da Categoria" name="st_nome" value="{{ old('st_nome') }}"> 
                            @if ($errors->has('st_nome'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_nome') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }}">
                        <label for="st_cpf" class="col-md-4 control-label">DESCRIÇÃO</label>

                        <div class="col-md-6">
                            <input id="st_descricao" type="text" class="form-control"  placeholder="Insira uma descrição para a categoria" name="st_descricao" value="{{ old('st_descricao') }}"> 
                            @if ($errors->has('st_descricao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_descricao') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("categorias")}}' class=" btn btn-danger"  title="Voltar">
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
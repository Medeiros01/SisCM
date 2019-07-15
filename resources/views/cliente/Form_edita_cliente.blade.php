@extends('adminlte::page')

@section('title', 'Editar cliente')

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
            <div class="panel-heading">editar Cliente</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/cliente/edita/'.$cliente->id) }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-4 control-label">Nome</label>

                        <div class="col-md-6">
                            <input id="st_nome" type="text" class="form-control" required="true" placeholder="Insira o Nome do Cliente" name="st_nome" value="{{$cliente->st_nome}}"> 
                            @if ($errors->has('st_nome'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_nome') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }}">
                        <label for="st_cpf" class="col-md-4 control-label">CPF</label>

                        <div class="col-md-6">
                            <input id="st_cpf" type="text" class="form-control"  placeholder="Insira o CPF do Cliente" name="st_cpf" value="{{$cliente->st_cpf }}"> 
                            @if ($errors->has('st_cpf'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_cpf') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_rg') ? ' has-error' : '' }}">
                        <label for="st_rg" class="col-md-4 control-label">RG</label>

                        <div class="col-md-6">
                            <input id="st_rg" type="text" class="form-control"  placeholder="número/órgao de emissão" name="st_rg" value="{{ $cliente->st_rg }}"> 
                            @if ($errors->has('st_rg'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_rg') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_endereco') ? ' has-error' : '' }}">
                        <label for="st_endereco" class="col-md-4 control-label">Endereço</label>

                        <div class="col-md-6">
                            <input id="st_endereco" type="text" class="form-control"  placeholder="nome da Rua, número e bairro" name="st_endereco" value="{{$cliente->st_endereco }}"> 
                            @if ($errors->has('st_endereco'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_endereco') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_municipio') ? ' has-error' : '' }}">
                        <label for="st_municipio" class="col-md-4 control-label">Município</label>

                        <div class="col-md-6">
                            <input id="st_municipio" type="text" class="form-control"  placeholder="Nome do Município" name="st_municipio" value="{{ $cliente->st_municipio}}"> 
                            @if ($errors->has('st_municipio'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_municipio') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_estado') ? ' has-error' : '' }}">
                        <label for="st_estado" class="col-md-4 control-label">UF</label>
                        <div class="col-md-6">
                            <select id="st_estado" name="st_estado" class="form-control" required="required">
                            <option value="{{$cliente->st_estado}}">{{$cliente->st_estado}}</option>
                                <option {{ old('st_ufnaturalidade') == 'AC' ? 'selected':''}} value="AC">AC</option>
                                <option {{ old('st_ufnaturalidade') == 'AL' ? 'selected':''}} value="AL">AL</option>
                                <option {{ old('st_ufnaturalidade') == 'AP' ? 'selected':''}} value="AP">AP</option>
                                <option {{ old('st_ufnaturalidade') == 'AM' ? 'selected':''}} value="AM">AM</option>
                                <option {{ old('st_ufnaturalidade') == 'BA' ? 'selected':''}} value="BA">BA</option>
                                <option {{ old('st_ufnaturalidade') == 'CE' ? 'selected':''}} value="CE">CE</option>
                                <option {{ old('st_ufnaturalidade') == 'DF' ? 'selected':''}} value="DF">DF</option>
                                <option {{ old('st_ufnaturalidade') == 'ES' ? 'selected':''}} value="ES">ES</option>
                                <option {{ old('st_ufnaturalidade') == 'GO' ? 'selected':''}} value="GO">GO</option>
                                <option {{ old('st_ufnaturalidade') == 'MA' ? 'selected':''}} value="MA">MA</option>
                                <option {{ old('st_ufnaturalidade') == 'MT' ? 'selected':''}} value="MT">MT</option>
                                <option {{ old('st_ufnaturalidade') == 'MS' ? 'selected':''}} value="MS">MS</option>
                                <option {{ old('st_ufnaturalidade') == 'MG' ? 'selected':''}} value="MG">MG</option>
                                <option {{ old('st_ufnaturalidade') == 'PA' ? 'selected':''}} value="PA">PA</option>
                                <option {{ old('st_ufnaturalidade') == 'PB' ? 'selected':''}} value="PB">PB</option>
                                <option {{ old('st_ufnaturalidade') == 'PR' ? 'selected':''}} value="PR">PR</option>
                                <option {{ old('st_ufnaturalidade') == 'PE' ? 'selected':''}} value="PE">PE</option>
                                <option {{ old('st_ufnaturalidade') == 'PI' ? 'selected':''}} value="PI">PI</option>
                                <option {{ old('st_ufnaturalidade') == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                                <option {{ old('st_ufnaturalidade') == 'RN' ? 'selected':''}} value="RN">RN</option>
                                <option {{ old('st_ufnaturalidade') == 'RS' ? 'selected':''}} value="RS">RS</option>
                                <option {{ old('st_ufnaturalidade') == 'RO' ? 'selected':''}} value="RO">RO</option>
                                <option {{ old('st_ufnaturalidade') == 'RR' ? 'selected':''}} value="RR">RR</option>
                                <option {{ old('st_ufnaturalidade') == 'SC' ? 'selected':''}} value="SC">SC</option>
                                <option {{ old('st_ufnaturalidade') == 'SP' ? 'selected':''}} value="SP">SP</option>
                                <option {{ old('st_ufnaturalidade') == 'SE' ? 'selected':''}} value="SE">SE</option>
                                <option {{ old('st_ufnaturalidade') == 'TO' ? 'selected':''}} value="TO">TO</option>
                            </select>
                            @if ($errors->has('st_estado'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_estado') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_celular') ? ' has-error' : '' }}">
                        <label for="st_celular" class="col-md-4 control-label">Celular</label>

                        <div class="col-md-6">
                            <input id="st_celular" type="text" class="form-control"  placeholder="(XX)XXXXX-XXXXX" name="st_celular" value="{{$cliente->st_celular}}"> 
                            @if ($errors->has('st_celular'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_celular') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_tel_fixo') ? ' has-error' : '' }}">
                        <label for="st_tel_fixo" class="col-md-4 control-label">Tel Fixo</label>

                        <div class="col-md-6">
                            <input id="st_tel_fixo" type="text" class="form-control"  placeholder="(XX)XXXXX-XXXXX" name="st_tel_fixo" value="{{$cliente->st_tel_fixo}}"> 
                            @if ($errors->has('st_tel_fixo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_tel_fixo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }}">
                        <label for="st_email" class="col-md-4 control-label">Tel Fixo</label>

                        <div class="col-md-6">
                            <input id="st_email" type="text" class="form-control"  placeholder="informe um e-mail válido" name="st_email" value="{{ $cliente->st_email }}"> 
                            @if ($errors->has('st_email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("clientes")}}' class=" btn btn-danger"  title="Voltar">
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
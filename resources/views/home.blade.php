@extends('adminlte::page')

@section('title', 'Home')



@section('content')
<div class="row">
    <div class="col-md-12">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Lista de férias que finalizam nos próximos 15 dias</legend>
            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-md-3">Nome do Funcionário</th>
                            <th class="col-md-2">Setor</th>
                            <th class="col-md-2">Função</th>
                            <th class="col-md-2">Início</th>
                            <th class="col-md-2">Fim</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($feriasFinal))
                        @foreach($feriasFinal as $ff)
                    <tr>
                        <th>{{$ff->st_nomefuncionario}}</th>
                        <th>{{$ff->st_siglasetor}}</th>
                        <th>{{$ff->st_funcao}}</th>
                        @foreach($ff->feriasFinal as $key => $valor)
                        @if($valor->st_nomeitem == 'Inicio')
                            <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                        @endif
                        @if($valor->st_nomeitem == 'Fim')
                            <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </fieldset>

        <fieldset class="scheduler-border">
                <legend class="scheduler-border">Lista de férias que iniciam nos próximos 15 dias</legend>
                <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-3">Nome do Funcionário</th>
                                <th class="col-md-2">Setor</th>
                                <th class="col-md-2">Função</th>
                                <th class="col-md-2">Início</th>
                                <th class="col-md-2">Fim</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($feriasInicio))
                            @foreach($feriasInicio as $fi)
                        <tr>
                            <th>{{$fi->st_nomefuncionario}}</th>
                            <th>{{$fi->st_siglasetor}}</th>
                            <th>{{$fi->st_funcao}}</th>
                            @foreach($fi->feriasInicio as $key => $valor)
                            @if($valor->st_nomeitem == 'Inicio')
                                <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                            @endif
                            @if($valor->st_nomeitem == 'Fim')
                                <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </fieldset>

            <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Lista de licenças que finalizam nos próximos 15 dias</legend>
                    <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Nome do Funcionário</th>
                                    <th class="col-md-2">Setor</th>
                                    <th class="col-md-2">Início</th>
                                    <th class="col-md-2">Fim</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($licencaFim))
                                @foreach($licencaFim as $lf)
                            <tr>
                                <th>{{$lf->st_nomefuncionario}}</th>
                                <th>{{$lf->st_siglasetor}}</th>
                                @foreach($lf->licencaFim as $key => $valor)
                                @if($valor->st_nomeitem == 'Inicio')
                                    <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                @endif
                                @if($valor->st_nomeitem == 'Fim')
                                    <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Lista de licenças que iniciam nos próximos 15 dias</legend>
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Nome do Funcionário</th>
                                        <th class="col-md-2">Setor</th>
                                        <th class="col-md-2">Início</th>
                                        <th class="col-md-2">Fim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($licencaInicio))
                                    @foreach($licencaInicio as $li)
                                <tr>
                                    <th>{{$li->st_nomefuncionario}}</th>
                                    <th>{{$li->st_siglasetor}}</th>
                                    @foreach($li->licencaInicio as $key => $valor)
                                    @if($valor->st_nomeitem == 'Inicio')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Fim')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @endforeach
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </fieldset>
    
       
    </div>
</div>
@stop
@extends('adminlte::page')

@section('title', 'Caixas')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
                @if(isset($caixas) && count($caixas) < 1)
                <div class="caixa">
                    <div class="col-md-4">
                            <a href="{{url("caixa/create")}}" class="btn btn-primary">ABRIR CAIXA</a>
                    </div>
                   
                </div>
                @endif
               {{--  Começa a exibição do caixas --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="2">LISTAGEM DE CAIXAS ABERTOS</th>
                                <th colspan="2">
                                    @if(isset($caixas) && count($caixas)> 0)
                                    Total de caixas abertos: {{count($caixas)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th >DATA DE ABERTURA</th>
                                <th >USUÁRIO</th>
                                <th >SITUAÇÃO</th>
                                @can('Administrador')
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($caixas))
                            @foreach($caixas as $c)
                        <tr style="font-size:12px" >
                            <th>{{date('d/m/Y', strtotime($c->dt_abertura))}}</th>
                            <th>{{$c->st_nome_usuario}}</th>
                            <th>{{$c->st_status}}</th>
                            @can('Administrador')
                            @if($c->ce_usuario == Auth::user()->id)
                           
                            <th  ><a href="{{url('caixa/detalhe/'.$c->id)}}" title="Detalhar"> <i class="glyphicon glyphicon-info-sign btn-xs"></i> Detalhar</a> </th>
                           
                            @endcan

                            @endif
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
@stop
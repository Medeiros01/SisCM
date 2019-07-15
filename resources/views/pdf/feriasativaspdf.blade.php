<html lang="pt-BR">

    <head>
        <meta http-equiv="Content-Language" content="pt-br">
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">
        <meta charset="utf-8">
        <link rel="icon" type="image/PNG" href="{{url('imgs/sesed.PNG')}}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{url('/imgs/logo2.png')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <title>{{$titulo or 'SESED'}}</title>
        
        <link rel='stylesheet' href="{{url('/assets/css/pdf.css')}}">

    </head>

        
    <body>
        <table class="table table-responsive">          
            <thead>
                <tr>
                    <th colspan="6"> LISTA DE FÉRIAS ATIVAS </th>
                </tr>
                <tr>
                    <th >NOME DO FUNCIONÁRIO</th>
                    <th >SETOR</th>
                    <th>FUNÇÃO</th>
                    <th >INÍCIO</th>
                    <th >FIM</th>
                    <th >ANO REFERENTE</th>
                </tr>
                </thead>
            <tbody>
                @if(isset($ferias))
                    @foreach($ferias as $fa)
                            @if($fa->campos[1]->st_valor <= $dataatual && $fa->campos[2]->st_valor >= $dataatual)
                            <tr>
                                <th>{{$fa->st_nomefuncionario}}</th>
                                <th>{{$fa->st_siglasetor}}</th>
                                <th>{{$fa->st_funcao}}</th>
                                @foreach($fa->campos as $key => $valor)
                                    @if($valor->st_nomeitem == 'Inicio')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Fim')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Referente')
                                        <th>{{$valor->st_valor}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            @endif
                        
                    @endforeach
                @endif
            </tbody>
        </table>
    </body>
</html>
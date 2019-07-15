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
                    <th colspan="5"> LISTA DE LICENÇAS ATIVAS </th>
                </tr>
                <tr>
                    <th >NOME DO FUNCIONÁRIO</th>
                    <th >SETOR</th>
                    <th>FUNÇÃO</th>
                    <th >INÍCIO</th>
                    <th >FIM</th>
                </tr>
                </thead>
            <tbody>
                @if(isset($licenca))
                    @foreach($licenca as $li)
                            @if($li->campos[1]->st_valor <= $dataatual && $li->campos[2]->st_valor >= $dataatual)
                            <tr>
                                <th>{{$li->st_nomefuncionario}}</th>
                                <th>{{$li->st_siglasetor}}</th>
                                <th>{{$li->st_funcao}}</th>
                                @foreach($li->campos as $key => $valor)
                                    @if($valor->st_nomeitem == 'Inicio')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Fim')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
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
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
                            <th colspan="6">RELAÇÃO DE GRATIFICAÇÃO</th>
                        </tr>
                        <tr>
                            <th >Nome</th>
                            <th >Valor</th>
                            <th >Quantidade de Vagas</th>
                            <th >Funcionários</th>
                            <th >Disponível</th>
                            <th >Total Gasto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($listGrat))
                            @foreach($listGrat as $grat)
                        <tr>
                            <th>{{$grat->st_gratificacao}}</th>
                            <th>R$ {{substr(str_replace(".",",", $grat->vl_gratificacao), 0, -2)}}</th>
                            <th>{{$grat->nu_vagas}}</th>
                            
                            @foreach($grat->listGrat as $key=>$valor)
                            @if ($valor->st_gratificacao == $grat->st_gratificacao)
                                <th>{{$valor->qtde}}</th>
                                <th>{{($grat->nu_vagas) - ($valor->qtde)}}</th>
                                <th>R$ {{($valor->qtde) * ($grat->vl_gratificacao)}}</th>
                            @endif                        
                            @endforeach         
                          
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
    </body>
</html>
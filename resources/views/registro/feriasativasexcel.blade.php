<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    </head>   
    <body>
<?php //declaramos uma variavel para monstarmos a tabela 
$dadosXls = ""; 
$dadosXls .= " <table border='1' >"; 
$dadosXls .= " <tr>"; 
$dadosXls .= " <th>Nome do Funcionário</th>";
$dadosXls .= " <th>Setor</th>";
$dadosXls .= " <th>Função</th>";
$dadosXls .= " <th>Início</th>"; 
$dadosXls .= " <th>Fim</th>"; 

$dadosXls .= " </tr>"; 
//incluimos nossa conexão include_once('Conexao.class.php'); 
//instanciamos $pdo = new Conexao(); 
//mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
//$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
//varremos o array com o foreach para pegar os dados 
foreach($licenca as $li){
    if($li->campos[1]->st_valor <= $dataatual && $li->campos[2]->st_valor >= $dataatual){
        $dadosXls .= " <tr>";
   
        $dadosXls .= " <td>".$li->st_nomefuncionario."</td>";
        $dadosXls .= " <td>".$li->st_siglasetor."</td>";
        $dadosXls .= " <td>".$li->st_funcao."</td>";
        foreach($li->campos as $key => $valor) {
            if($valor->st_nomeitem == 'Inicio'){
                $dadosXls .= " <td>".$valor->st_valor."</td>"; 
            }
            if($valor->st_nomeitem == 'Fim'){
                $dadosXls .= " <td>".$valor->st_valor."</td>";
            }
            if($valor->st_nomeitem == 'Referente'){
                $dadosXls .= " <td>".$valor->st_valor."</td>";
            }
        }  
        $dadosXls .= " </tr>";
    }
}
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "FeriasAtivas.xls";
// Configurações header para forçar o download 
 header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
 header('Content-Disposition: attachment;filename="'.$arquivo.'"');
 header('Cache-Control: max-age=0');
 // Se for o IE9, isso talvez seja necessário 
 // header('Cache-Control: max-age=1'); 
  // Envia o conteúdo do arquivo 
  echo $dadosXls; exit; ?>

    </body>
</html>
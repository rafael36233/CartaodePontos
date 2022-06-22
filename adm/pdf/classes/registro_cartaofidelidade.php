<?php

require_once "site.php";

class registro_cartaofidelidade extends Site
{

    private $numero;
    private $cliente;
    private $carimbo;
    private $andamento;


    function __construct()
    {
        parent::__construct();

        // BOTAO CARIMBAR
        if (isset($_POST['formSalvarCarimbo']))
            $this->salvarCarimbo();
        if (substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1, -4) != 'dashboard') {
            $registros = new cartaofidelidade();
            $registros = $registros->todosCartoesPorLoja();
            if (empty($registros)) {
                setAlerta('warning', 'Você não possue nenhum cartão, primeiro cadastre um!');
                header('Location: cartoes.php');
            }
        }
    }


    public function clientesPorLoja()
    {
        $id_loja = $_SESSION['empresa_id'];
        // CONTA E TRAZ OS DADOS DO CARTAO FIDELIDADE E DO CLIENTE EM QUESTAO, CONTANDO O NUMERO DE CARIMBOS JA RESGISTRADOS
        $sql = "select clientes.numero,clientes.nome, cF.nome_cartao,sum(registro_cartaofidelidade.pontos) as pontos,cF.objetivo from registro_cartaofidelidade
                inner join cartaofidelidade cF on registro_cartaofidelidade.fk_carimbo = cF.id
                LEFT join clientes on clientes.numero=registro_cartaofidelidade.fk_cliente
                LEFT JOIN lojas on lojas.id=cF.fk_loja
                WHERE lojas.id='$id_loja'  and registro_cartaofidelidade.status='0'
                GROUP BY registro_cartaofidelidade.fk_cliente, registro_cartaofidelidade.fk_carimbo";
        $query = mysqli_query($this->conexao, $sql);
        if ($query)
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        else
            return false;
    }

    public function clientesPorLojaLimit10()
    {
        $id_loja = $_SESSION['empresa_id'];
        // CONTA E TRAZ OS DADOS DO CARTAO FIDELIDADE E DO CLIENTE EM QUESTAO, CONTANDO O NUMERO DE CARIMBOS JA RESGISTRADOS COM LIMITE DE 10
        $sql = "select c.numero,c.nome,cF.nome_cartao,sum(registro_cartaofidelidade.pontos) as pontos,cF.objetivo from registro_cartaofidelidade
                inner join cartaofidelidade cF on registro_cartaofidelidade.fk_carimbo = cF.id
                inner join lojas l on cF.fk_loja = l.id
                inner join clientes c on registro_cartaofidelidade.fk_cliente = c.numero  where l.id = '$id_loja'
                 group by fk_carimbo, fk_cliente limit 4";
        $query = mysqli_query($this->conexao, $sql);
        if ($query)
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        else
            return false;
    }

    public function clientePorLoja($id_loja, $numero, $id_cupom)
    {
        // CONTA E TRAZ OS DADOS DO CARTAO FIDELIDADE E DO CLIENTE EM QUESTAO, CONTANDO O NUMERO DE CARIMBOS JA RESGISTRADOS
        $sql = "select c.numero,c.nome,cF.nome_cartao,sum(registro_cartaofidelidade.pontos) as pontos,cF.objetivo from registro_cartaofidelidade
                inner join cartaofidelidade cF on registro_cartaofidelidade.fk_carimbo = cF.id
                inner join lojas l on cF.fk_loja = l.id
                inner join clientes c on registro_cartaofidelidade.fk_cliente = c.numero  where l.id = '$id_loja' and registro_cartaofidelidade.status='0'
                 group by fk_carimbo, fk_cliente  ";
        $query = mysqli_query($this->conexao, $sql);
        if ($query)
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        else
            return false;
    }

    public function todosCartoesPorLoja()
    {
        $id_loja = $_SESSION['empresa_id'];
        $sql = "select *,valor as valorc from cartaofidelidade where fk_loja = '$id_loja'
                and data_inicio < now() and data_fim > now() ";
        $query = mysqli_query($this->conexao, $sql);
        if ($query)
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        else
            return "";

    }

   public function salvarCarimbo()
    {
                $total = $_POST['total'];
                $valor_unitario = $_POST['valor_unitario'];



        // SALVA UM NOVO CARIMBO
        $numero = limpaMascaraNumero($_POST['number']);
        $id_cupom = $_POST['cupom'];

        $sql = "select * from clientes where numero = '$numero'";
        $result = mysqli_fetch_all(mysqli_query($this->conexao, $sql));
        if (count($result) == 1) {
            if ($this->verificaSeCompletouCupom($numero, $id_cupom)) {
                setAlerta('danger', 'Esse usuário já completou esse cartão!');
                header("Location: registro_pontos.php");
            } else {
                $sql = "INSERT INTO registro_cartaofidelidade (id, fk_cliente, fk_carimbo, data_registro,pontos,valor) 
                    VALUES (NULL, '$numero', '$id_cupom', CURRENT_TIME(),'$total','$valor_unitario');";
                $query = mysqli_query($this->conexao, $sql);
                if ($query) {
                    $dados = $this->clientePorLoja($_SESSION['empresa_id'],$numero,$id_cupom);
                    if ($dados[0]["count(fk_cliente)"] == '1'){
                    
                    }
                    if ($this->verificaSeCompletouCupom($numero, $id_cupom)) {
                     
                      
                       
                   
                    } else {
                  header("Location: registro_pontos.php");

                    }
                } else {
                    Alert('danger', 'Algo deu errado, tente novamente!');
                    header("Location: novo_ponto.php");
                }
            }
        } 
    }


    public function verificaSeCompletouCupom($numero, $id_cupom)
    {
        // VERIFICA SE O CUPOM JA FOI COMPLETADO PELO USUARIO EM QUESTAO
        $sql = "select sum(registro_cartaofidelidade.pontos) as num, cF.objetivo from registro_cartaofidelidade
                inner join cartaofidelidade cF on registro_cartaofidelidade.fk_carimbo = cF.id
                where fk_cliente = '$numero' and fk_carimbo = '$id_cupom' and registro_cartaofidelidade.status='0' GROUP by registro_cartaofidelidade.fk_cliente";
        $query = mysqli_query($this->conexao, $sql);
        $result = mysqli_fetch_assoc($query);
        
            if ($result['num']=="") {
                
            }else{
        if ($result['num']+$total >= $result['objetivo']) {
$totalp=$result['num']+$total -$result['objetivo'];
                           $token = new tokens();
                        $token = $token->createToken($numero, $id_cupom,$totalp);
                        setAlerta('success', 'Completou cartão, token gerado!');
                        header("Location: registro_pontos.php");
                        
if ($totalp>= $result['objetivo']){
    
    $totalp2=$totalp - $result['objetivo'];
       $token = new tokens();
                        $token = $token->createToken($numero, $id_cupom,$totalp2);
                        setAlerta('success', 'Completou cartão, token gerado!');
                        header("Location: registro_pontos.php");
}
                      
                     
                
                 
        } else{
            
        setAlerta('success', 'Pontos Registrados!');
                        header("Location: registro_pontos.php");
            
        }
    }}

    public function desempenhoSemanal(){
        $id_loja = $_SESSION['empresa_id'];
        $sql = "CALL carimbos_7_dias('$id_loja')";
        $query = mysqli_query($this->conexao, $sql);
        if ($query){
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
            mysqli_free_result($query);
            return $result;
        }
        else
            return false;
    }

     public function numClientesPorLoja(){
        $id_loja = $_SESSION['empresa_id'];
        $sql = "select count(distinct fk_cliente) as num from tokens
                inner join cartaofidelidade cF on tokens.fk_carimbo = cF.id 
                inner join lojas l on cF.fk_loja = l.id  where l.id = '$id_loja'";
         $query = mysqli_query($this->conexao, $sql);
         $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
         return $result[0]['num'];


     }
   public function totalloja(){
        $id_loja = $_SESSION['empresa_id'];
        $sql = "SELECT SUM(PONTOS) as totalpontos from registro_cartaofidelidade rc INNER JOIN  cartaofidelidade cf on cf.id=rc.fk_carimbo ";
        $query = mysqli_query($this->conexao, $sql);
        if ($query){
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
            mysqli_free_result($query);
            return $result;
        }
        else
            return false;
    }


     }
     
     



<?php

require_once "/../classes/registro_cartaofidelidade.php";


$registros = new registro_cartaofidelidade();
$cartoes = new cartaofidelidade();


$numClientesPorLoja = $registros->numClientesPorLoja();

$numCartoesAtivos = $cartoes->numCartoesAtivos();

$numCartoesCompletados = $cartoes->numCartoesCompletados();


$dados = $registros->clientesPorLoja();

$dados_grafico = array_reverse($registros->desempenhoSemanal());

$totalloja = $registros->totalloja();

include "../include/header.php";

// INCLUINDO NAVBAR
$ativo = "dashboard";
include "../include/navbar.php";
?>
</nav>
<div id="layoutSidenav_content">
<?php getAlerta(); ?>

                <main>
                <br>
                <br>


                    <div class="container-fluid px-4">
                        <div class="content">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-credit-card text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category"><h6>Cartões</h6></p>
                      <p class="card-title"><?=$numCartoesAtivos?><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
Cartões Ativos
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-single-02 text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category"><h6>Clientes</h6></p>
                      <p class="card-title"><?=$numClientesPorLoja?><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  Clientes Cadastrados
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-danger"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category"><h6>Vendas</h6></p>
                      <p class="card-title"><?=$numCartoesCompletados?><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-clock-o"></i>
                  Vendas no dia de hoje
                </div>
              </div>
            </div>
          </div>
          
                   
 <div class="container">

                <div class="card">



<table id="productTable" class="table table-striped table-bordered"  width="98%">



					<thead>

						<th>Telefone</th>
						<th>Nome </th>

						<th> Cartão </th>
						<th>Progresso  </th>
					
					</thead>
                    
					<tbody>
                        
					<?php 
						foreach($dados as $chave => $valor) : 
                            if (empty($valor['nome']))
                            $valor['nome'] = "Usuário Temporário";
                        ?>
                    
                        
                        <div class="bg-white mb-1 shadow-sm">
							<tr>
								<td>
                                <?= formatacaoCelular($valor['numero']) ?><br>
                             </td>
                                <td>                               <?= limitaTexto(30,$valor['nome']) ?>
 </td>

								<td><div class="card-body"> <?php echo $valor['nome_cartao']; ?></div> </td>


								<td>
                                    <div class="progress-bar <?= ($porcentagem >= 70 ? 'progress-bar-striped' : '') ?> <?= ($porcentagem == 100 ? 'bg-success' : 'bg-success') ?>" role="progressbar" style="width: <?= $porcentagem ?>%" aria-valuemin="0" aria-valuemax="100"><?php echo $valor['pontos'] ?>
                                        /<?= $valor['objetivo'] ?>
                                    </div>
                                </td>
								
							</tr>
                      
						<?php endforeach; ?>	
					</tbody>	
				</table>
	  <br>
    <br>
    <br>
    <br>
        <br>
    <br>
    <br>
    <br>
    <br>
                        </div>  
                        </div>
  
    <br>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

</body>
</html>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">


<!-- CDN jQuery Datatable -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<script>
	$(document).ready(function() {
    	$('#productTable').DataTable();
	});
	
</script>




    <?php include "include/footer.php" ?>



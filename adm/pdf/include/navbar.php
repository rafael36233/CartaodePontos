

  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="index.php" class="simple-text logo-mini">
          <div class="logo-image-small">
          <?php if ($_SESSION['empresa_img'] != null && $_SESSION['empresa_img'] != '') : ?>
                    <img  src="../uploads/<?= $_SESSION['empresa_img'] ?>" class="rounded-circle border-orange">
                <?php else : ?>
                    <img src="../media/images/perfil_generico.jpg"  class="rounded-circle  border-orange">
                <?php endif; ?>          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="index.php" class="simple-text logo-normal">
        <?= $_SESSION['empresa_nome'] ?>        
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="dashboard.php">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="cartoes.php">
                      <i class="nc-icon nc-credit-card"></i>
<strong>              <p>Cartões</p>
</strong>
            </a>
          </li>
          <li>
            <a href="registro_pontos.php">
              <i class="nc-icon nc-pin-3"></i>
              <p><strong>Pontos</strong></p>
            </a>
          </li>
            <li>
            <a href="whats.php">
              <i>    <img src="https://cdn-icons-png.flaticon.com/512/1419/1419525.png" width="27" class="rounded-circle  border-orange"></i>
           
              <p><strong>WhatsApp</strong></p>
            </a
          <li>
            <a href="pdf/index.php" target="blank">
              <i class="nc-icon nc-paper"></i>
              <p><strong>Relatorios</strong></p>
            </a>
          </li>
          
          <li>
            <a href="validar_token.php">
              <i class="nc-icon nc-tile-56"></i>
         <strong>     <p>Validar Token</p></strong>
            </a>
          </li>
        
          <li>
            <a href="configuracoes.php">
              <i class="nc-icon nc-single-02"></i>
<strong>              <p>Meu Perfil</p>
</strong>
            </a>
          </li>
          <li class="active ">
            <a href="./upgrade.html" >
              <i class="nc-icon nc-share-66" ></i>
              <strong>              <p>Logout</p>
</strong>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
     
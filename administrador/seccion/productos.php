<?php include("../template/cabecera.php") ?>

<?php
  $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
  $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
  $txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
  $txtCategoria = (isset($_POST['txtCategoria'])) ? $_POST['txtCategoria'] : "";
  $txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
  $txtComentarios = (isset($_POST['txtComentarios'])) ? $_POST['txtComentarios'] : "";
  $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

  include("../config/bd.php");

  switch ($accion) {
    case 'Agregar':
      $sentenciaSQL = $conexion->prepare("INSERT INTO productos (nombre,imagen,categoria,precio,comentarios) VALUES (:nombre,:imagen,:categoria,:precio,:comentarios);");
      $sentenciaSQL->bindParam(':nombre', $txtNombre);
      $sentenciaSQL->bindParam(':categoria', $txtCategoria);
      $sentenciaSQL->bindParam(':precio', $txtPrecio);
      $sentenciaSQL->bindParam(':comentarios', $txtComentarios);
      $fecha= new DateTime();
      $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
      $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
    
      if($tmpImagen!=""){
        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
      }
    
      $txtImagen = $nombreArchivo; // Corrección
    
      $sentenciaSQL->bindParam(':imagen',$txtImagen);
      $sentenciaSQL->execute();
    
      header("Location:productos.php");
    
      break;
      
    case 'Modificar':
      $sentenciaSQL = $conexion->prepare("UPDATE productos SET nombre=:nombre, categoria=:categoria, precio=:precio, comentarios=:comentarios WHERE id=:id");
      $sentenciaSQL->bindParam(':nombre', $txtNombre);
      $sentenciaSQL->bindParam(':categoria', $txtCategoria);
      $sentenciaSQL->bindParam(':precio', $txtPrecio);
      $sentenciaSQL->bindParam(':comentarios', $txtComentarios);
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();

      if($txtImagen!=""){
            
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        if( isset($producto["imagen"]) &&($producto["imagen"]!="imagen.jpg") ){

            if(file_exists("../../img/".$producto["imagen"])){

                unlink("../../img/".$producto["imagen"]);
                
            }
        }

        $sentenciaSQL= $conexion->prepare("UPDATE productos SET imagen=:imagen WHERE id=:id");
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
    }

      header("Location: productos.php");
      break;

    case 'Cancelar':
      header("Location:productos.php");
      break;

    case 'Seleccionar':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      $txtNombre = $producto['nombre'];
      $txtImagen=$producto['imagen'];
      $txtCategoria = $producto['categoria'];
      $txtPrecio = $producto['precio'];
      $txtComentarios = $producto['comentarios'];
      break;

    case 'Borrar':
      $sentenciaSQL = $conexion->prepare("SELECT id FROM productos WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      header("Location:productos.php");

      break;
  }

  $sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
  $sentenciaSQL->execute();
  $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      Datos de productos
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="txtID">ID:</label>
          <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
        </div>
        <div class="form-group">
          <label for="txtNombre">Nombre:</label>
          <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del producto">
        </div>
        <div class = "form-group">
          <label for="txtImagen">Imagen:</label>
            <br/>

          <?php
            if($txtImagen!=""){
          ?>
              <img class="rounded img-fluid w-25" src="../../img/<?php echo $txtImagen;?>" alt="" srcset="">
          <?php
              }
          ?>
          <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Inserta una imagen del producto">
          </div>
        
        <div class="form-group">
          <label for="txtCategoria">Categoria:</label>
          <input type="text" required class="form-control" value="<?php echo $txtCategoria; ?>" name="txtCategoria" id="txtCategoria" placeholder="Ingrese la categoria del producto">
        </div>
        <div class="form-group">
          <label for="txtPrecio">Precio:</label>
          <input type="number" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Ingrese el precio del producto">
        </div>
        <div class="form-group">
          <label for="txtComentarios">Comentarios:</label>
          <input type="text" class="form-control" value="<?php echo $txtComentarios; ?>" name="txtComentarios" id="txtComentarios" placeholder="Ingrese comentarios sobre el producto">
        </div>
        <div class="btn-group" role="group" aria-label="">
          <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
          <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
          <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-md-8">
  <div class="container">
    <input type="text" id="buscador" class="form-control mb-2" placeholder="Buscar productos">
    <table id="tablaProductos" class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>Categoria</th>
          <th>Precio</th>
          <th>Comentarios</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listaProductos as $producto) { ?>
          <tr>
            <td><?php echo $producto['id']; ?></td>
            <td><?php echo $producto['nombre']; ?></td>
            <td>
                
                <img class="rounded img-fluid w-25" src="../../img/<?php echo $producto['imagen']; ?>" alt="" srcset="">
    
                </td>
    
            <td><?php echo $producto['categoria']; ?></td>
            <td><?php echo $producto['precio']; ?></td>
            <td><?php echo $producto['comentarios']; ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['id']; ?>" />
                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  // Filtrar productos en tiempo real
  document.getElementById('buscador').addEventListener('input', function() {
    var filtro = this.value.toLowerCase();
    var filas = document.querySelectorAll('#tablaProductos tbody tr');

    for (var i = 0; i < filas.length; i++) {
      var columnaNombre = filas[i].querySelectorAll('td')[1].textContent.toLowerCase();
      var columnaCategoria = filas[i].querySelectorAll('td')[2].textContent.toLowerCase();

      if (columnaNombre.indexOf(filtro) !== -1 || columnaCategoria.indexOf(filtro) !== -1) {
        filas[i].style.display = '';
      } else {
        filas[i].style.display = 'none';
      }
    }
  });
</script>

<?php include("../template/pie.php") ?>

<?php
    require "conexion.php";
    
    $datos = json_decode(file_get_contents("php://input"));
    $request = $datos->request;
    
    // READ: Leer los registros de la base de datos
    if($request == 1){
      $sql = "SELECT idUsuario, nombre, telefono FROM usuarios";
      $query = $mysqli->query($sql);
        
      $datos = array();
      while($resultado = $query->fetch_assoc()) {
        $datos[] = $resultado;
      }
        
      echo json_encode($datos);
      exit;
    }

    // CREAD: Insertar registro en la base de datos
    if($request == 2) {

      $nombre = $datos->nombre;
      $telefono = $datos->telefono;

      $sql_select = "SELECT nombre FROM usuarios WHERE nombre='$nombre'";
      $query_select = $mysqli->query($sql_select);

      if(($query_select->num_rows) == 0) {
        // Inserta los datos correspondientes
        $sql_insert = "INSERT INTO usuarios(nombre, telefono) VALUES('$nombre', '$telefono')";
        if($mysqli->query($sql_insert) === TRUE) {
          echo "Se registro exitosamente.";
        } else {
          echo "Ocurrio un problema.";
        }
      } else {
        echo "Esos datos ya existen.";
      }
      exit;
    }

    // UPDATE: Actualizar el registro de la base de datos
    if($request == 3) {

      $idUsuario = $datos->idUsuario;
      $nombre = $datos->nombre;
      $telefono = $datos->telefono;

      $sql_edit = "UPDATE usuarios SET nombre='$nombre', telefono='$telefono' WHERE idUsuario='$idUsuario'";
      $query_update = $mysqli->query($sql_edit);

      echo "Se actualizo el registro.";
      exit;
    }

    // DELETE: Borrar registro de la base de datos
    if($request == 4) {
      
      $idUsuario = $datos->idUsuario;

      $sql_delete = "DELETE FROM usuarios WHERE idUsuario='$idUsuario'";
      $query_delete = $mysqli->query($sql_delete);

      echo "Registro eliminado.";
      exit;
    }

?>
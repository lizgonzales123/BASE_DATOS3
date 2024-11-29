<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar carreras</title>
    <style>
        @keyframes move {
            70% { transform: translateX(200px); }
            50% { transform: translateX(10px); }
            100% { transform: translateX(10px); }
        }
        body {
            font-family: Arial, sans-serif;
            
            
            height: 70vh;
            margin: 0;
            padding-left: 50px;
        }
        .container {
            border-radius: 5px;
            font-size: 1.5em;
            color: white;
            background-color: #020202;
            padding: 15px;
            
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 400px;
        }
        h2 {
            font-size: 3em;
           
            color: #020202;
            animation: move 4s infinite;
        }
        input[type="text"], input[type="number"] {
            width: calc(90% - 30px);
            padding:10px;
            margin: 5px 0;
            border: 3px solid #ccc;
            border-radius: 0px;
            transition: border-color 0.3s;
        }
        input[type="text"]:hover, input[type="number"]:hover {
            border-color: #009879;
        }
        .btn {
            background-color: #0b3ad4ef;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #50c1ee;
        }
    </style>
</head>




<?php
// Conectar a la base de datos
$host = "localhost";//DONDE ESTA TU BASE DE DATOS
$dbname = "ibmv";//NOMBRE DE LA BASE DE TATOS
$user = "root"; // CAMBIAR SI ES NECERARIO
$password = ""; // CAMBIAR SI ES NECESARIO

//  CREAR CONEXION
$conn = new mysqli($host, $user, $password, $dbname);


// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$row = null; // Inicializa la variable $row para evitar errores si no se encuentra el usuario

// Verificar si 'id_usuario' está presente en la URL y es un número válido
if (isset($_GET['Id']) && is_numeric($_GET['Id'])) {
    $id = $_GET['Id'];
    

   

    // Obtener el usuario por ID
    $sql = "SELECT * FROM administrativos WHERE Id = $id";  // Corregido aquí

    
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        // Depuración: Mostrar mensaje si no se encuentra el usuario
        echo "Usuario no encontrado para el ID: " . $id . "<br>";
        exit();  // Detiene la ejecución si no se encuentra el usuario
    }
} else {
    // Si el id no está presente o no es un número válido
    echo "ID de usuario no válido o no proporcionado.";
    exit();
}

// Guardar los cambios en la base de datos
if (isset($_POST['editar'])) {
  
    $Nombre = $_POST['Nombres'];
    $Apellidop = $_POST['Apellidop'];
    $Apellidom= $_POST['Apellidom'];
    $Asignatura= $_POST['Cargo'];
    $correo= $_POST['correo'];
   

    $sql = "UPDATE administrativos SET Nombres =' $Nombre', Apellidop='$Apellidop', Apellidom='$Apellidom',  Cargo ='$Asignatura',  correo ='$correo' WHERE Id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado correctamente";
        header("Location: registrop.php"); // Redirige a la lista de usuarios
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar </title>
</head>
<body>
    <h2>Editar Administrativos</h2>

    <?php if (isset($row) && $row): ?>  <!-- Verifica que $row esté definido y contenga datos -->
    <div class="container">
        <form method="POST" action="">
            <input type="hidden" name="" value="<?php echo $row['Id']; ?>">
            
            <label for="Nombres">Nombre Docente</label>
            <input type="text" id="Nombres" name="Nombres" value="<?php echo $row['Nombres']; ?>" required><br><br>

            <label for="Apellidop">Apellido paterno:</label>
            <input type="text" id="Apellidop" name="Apellidop" value="<?php echo $row['Apellidop']; ?>" required><br><br>

            <label for="Apellidom">Apellido Materno:</label>
            <input type="text" id="Apellidom" name="Apellidom" value="<?php echo $row['Apellidom']; ?>" required><br><br>

            <label for="Asignatura">Cargo</label>
            <input type="text" id="Cargo" name="Cargo" value="<?php echo $row['Cargo']; ?>" required><br><br>

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="<?php echo $row['correo']; ?>" required><br><br>

            

            <input type="submit" name="editar" value="Guardar Cambios" class="btn">
        </form>
        </div>    
    <?php else: ?>
        <p>No se encontró el usuario para editar.</p>
    <?php endif; ?>

</body>
</html>

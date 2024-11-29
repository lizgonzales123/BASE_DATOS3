<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aula</title>
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
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    

   

    // Obtener el usuario por ID
    $sql = "SELECT * FROM registroaula WHERE id = $id";  // Corregido aquí

    
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
  
    $Numaulas = $_POST['Numaulas'];
    $Capacidad = $_POST['Capacidad'];
    $Ubicacion= $_POST['Ubicacion'];
    $Equipamiento= $_POST['Equipamiento'];

    $sql = "UPDATE registroaula SET Numaulas =' $Numaulas', Capacidad='$Capacidad', Ubicacion ='$Ubicacion',  Equipamiento ='$Equipamiento' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado correctamente";
        header("Location: base.php"); // Redirige a la lista de usuarios
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
    <title>Editar Aulas</title>
</head>
<body>
    <h2>Editar Aulas</h2>

    <?php if (isset($row) && $row): ?>  <!-- Verifica que $row esté definido y contenga datos -->
    <div class="container">
        <form method="POST" action="">
            <input type="hidden" name="id_usuario" value="<?php echo $row['id']; ?>">
            
            <label for="Numaulas">Nº AULA:</label>
            <input type="text" id="Numaulas" name="Numaulas" value="<?php echo $row['Numaulas']; ?>" required><br><br>

            <label for="Capacidad">Capacidad:</label>
            <input type="number" id="Capacidad" name="Capacidad" value="<?php echo $row['Capacidad']; ?>" required><br><br>

            <label for="Ubicacion">Ubicacion:</label>
            <input type="text" id="Ubicacion" name="Ubicacion" value="<?php echo $row['Ubicacion']; ?>" required><br><br>
            <label for="Equipamiento">Equipamiento</label>
            <input type="text" id="Equipamiento" name="Equipamiento" value="<?php echo $row['Equipamiento']; ?>" required><br><br>

            <input type="submit" name="editar" value="Guardar Cambios" class="btn">
        </form>
        </div>    
    <?php else: ?>
        <p>No se encontró el usuario para editar.</p>
    <?php endif; ?>

</body>
</html>

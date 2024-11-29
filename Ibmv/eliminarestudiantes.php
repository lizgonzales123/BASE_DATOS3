<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "ibmv");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario por ID
    $sql = "DELETE FROM registrostudy WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();

// Redirigir a la lista de usuarios
header("Location: basestudy.php");
exit();
?>
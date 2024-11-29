<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta DB</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        body {
          font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #ff00003a, #f2ff0053, #ff00ff53);
            
            height: 100vh;
            margin: 0;
        }
        table {
           
            
            font-size: 18px;
            text-align: left;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        th, td {
            padding: 1px 15px;
        }
        th {
            background-color: #009879;
            color: #ffffff;
           
        }
        tr {
            border-bottom: 1px solid #dddddd;
        }
        tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        h2 {
            color: #333333;
        }
    </style>
</head>
<body>
    <h2>Lista de Carreras</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Carrera</th>
                <th>Duracion</th>
                <th>Materias</th>
                <th>Coordinador</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Validamos datos del servidor
            $user = "root";
            $pass = "";
            $host = "localhost";
            $datab = "sistem";

            // Conectamos a la base de datos
            $connection = new mysqli($host, $user, $pass, $datab);

            // Verificamos la conexión a la base de datos
            if ($connection->connect_error) {
                die("No se ha podido conectar con el servidor: " . $connection->connect_error);
            } else {
                echo "<b><h3></h3></b>";
            }

            // Indicamos el nombre de la base de datos
            $datab = "ibmv";
            // Indicamos seleccionar la base de datos
            $db = mysqli_select_db($connection, $datab);

            if (!$db) {
                echo "No se ha podido encontrar la Tabla";
            } else {
                echo "<h3></h3>";
            }

            // Verificamos que las claves existan en el array $_POST
            $nom = isset($_POST['Nomcarrera']) ? $_POST['Nomcarrera'] : '';
            $duracion = isset($_POST['Duracion']) ? $_POST['Duracion'] : '';
            $nmaterias = isset($_POST['Numaterias']) ? $_POST['Numaterias'] : '';
            $cordinador = isset($_POST['Coordinadorc']) ? $_POST['Coordinadorc'] : '';

            // Insertamos datos de registro al MySQL, indicando nombre de la tabla y sus atributos
            if (!empty($nom) && !empty($duracion ) && !empty($nmaterias) && !empty($cordinador)) {
                $instruccion_SQL = "INSERT INTO carreras_ibm (Nomcarrera, Duracion, Numaterias, Coordinadorc) VALUES ('$nom', '$duracion', '$nmaterias', '$cordinador')";
                $resultado = mysqli_query($connection, $instruccion_SQL);

                // Redirigimos a otra página después de insertar los datos
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Consultamos todos los registros
            $consulta = "SELECT * FROM carreras_ibm";
            $result = mysqli_query($connection, $consulta);

            if ($result->num_rows > 0) {
                while ($colum = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $colum['id'] . "</td>";
                    echo "<td>" . $colum['Nomcarrera'] . "</td>";
                    echo "<td>" . $colum['Duracion'] . "</td>";
                    echo "<td>" . $colum['Numaterias'] . "</td>";
                    echo "<td>" . $colum['Coordinadorc'] . "</td>";
                    echo "<td>
                              <a href='editarcarrera.php?id=" . $colum['id'] . "' class='btn btn-primary btn-sm'>
                                  <i class='fas fa-edit'></i> Editar
                              </a>
                              <a href='eliminarcarreras.php?id=" . $colum['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\")'>
                                  <i class='fas fa-trash-alt'></i> Eliminar
                              </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay aulas registradas</td></tr>";
            }

            // Cerramos la conexión
            $connection->close();
            ?>
        </tbody>
    </table>
    <a href="index.html" class="btn btn-secondary">Inicio</a>
    <a href="carreras.html" class="btn btn-success">Registrar Nueva Carrera</a>

    <!-- Bootstrap JS and Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buscar Registros</title>
    <h1 align = 'center'>PRÁCTICA SQL-INJECTION</h1>
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "root";
        $passwor = "";
        $dbname = "practica";

        $connection = new mysqli($servername, $username, $passwor, $dbname);
        

        $botbuscarEmp="";
        $emprebuscar="";
        $emprebuscarEmail="";
        $emprebuscarPass="";

    ?>

    <br>
    <form action="index.php" method = "POST" align = "center">
        Usuario: <input type="text" required name = "txtbuscar">
        Email: <input type="text" required name = "txtbuscaremail">
        Contraseña: <input type="password" required name = "txtbuscarpass">
        <input type="submit" value="Buscar" name = "namebotbuscarEmp">
    </form>

    <br>

    <?php
        /* validar boton */
        if(isset($_POST['namebotbuscarEmp']))
            $botbuscarEmp=$_POST['namebotbuscarEmp'];

        if($botbuscarEmp){
            /* Verificar coneccion */ 
            if($connection->connect_error){
                echo "<script>
                    alert ('No hay coneccion con base de datos');
                    window.location = 'index.php';
                </script>";

                die("Connection faliled: " . $connection->connect_error);
            }
            else{
                $emprebuscar = mysqli_real_escape_string($connection,$_POST['txtbuscar']);
                $emprebuscarEmail = mysqli_real_escape_string($connection,$_POST['txtbuscaremail']);
                $emprebuscarPass = mysqli_real_escape_string($connection, $_POST['txtbuscarpass']);
                $sqlListEmpre = "
                    select 
                        u.id,
                        u.email,
                        u.password
                    from
                        usuarios u
                    where
                        u.id = '$emprebuscar'
                        and u.email = '$emprebuscarEmail'
                        and u.password = '$emprebuscarPass'
                ";
                $resultList = $connection->query($sqlListEmpre);

                if(mysqli_num_rows($resultList) > 0){
                    echo "<table border = '1' align = 'center'>";
                    echo "<tr>";
                        echo "<td>USUARIO</td>";
                        echo "<td align = 'center'>EMAIL</td>";
                        echo "<td>PASSWORD</td>";
                    echo "</tr>";
                    while($row = $resultList->fetch_assoc()){
                        echo "<tr>";
                            echo "<td align = 'center'>".$row['id']."</td>";
                            echo "<td align = 'center'>".$row['email']."</td>";
                            echo "<td align = 'center'>".$row['password']."</td>";
                        echo "</tr>";
                    }
                echo "</table>";
                } else{
                    echo "<script>
                    alert ('Verifique los Campos Diligenciados.... No hay Resultados');
                    window.location = 'index.php';
                </script>";
                }
            }
        }
    ?>

    <br>
    <center>
        <a href="index.php">
            <img src="img/botonregresar.jpg" width = "100" heigth = "50">
        </a>
    </center>
</body>
</html>
<!doctype html>
<html>

<head>
    <title>Plugin jquery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type='text/javascript' src="plugin/plugin.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="row" style="padding:50px;">
            <p>
            <h1>Plugin para editar las tablas haciendo doble Click en el nombre en la base de datos.</h1>
            </p>
            <table width='100%' border='0'>
                <tr>
                    <th width='10%'>No</th>
                    <th width='40%'>Username</th>
                    <th width='40%'>Name</th>
                </tr>
                <?php
                include('dbcon.php');
                $count = 1;
                $query = $conn->query("SELECT * FROM users order by id");
                while ($row = $query->fetch_object()) {
                    $id = $row->id;
                    $username = $row->username;
                    $name = $row->name;
                ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td>
                            <div class='edit'> <?php echo $username; ?></div>
                            <input type='text' class='txtedit' value='<?php echo $username; ?>' id='username_<?php echo $id; ?>'>
                        </td>
                        <td>
                            <div class='edit'><?php echo $name; ?> </div>
                            <input type='text' class='txtedit' value='<?php echo $name; ?>' id='name_<?php echo $id; ?>'>
                        </td>
                    </tr>
                <?php
                    $count++;
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>
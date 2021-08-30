<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>To-do List</h1>
        </div>
    </header>
    <main>
        <section class="container">

        <form method="post" class="center">
            <input type="text" name="activity">
            <input type="submit" name="cadastrar">
        </form>

        <?php 
            if(isset($_POST["cadastrar"])){
                $atv = $_POST["activity"];
                $pdo = new PDO("mysql:host=localhost;dbname=todo", "root", "");
                $sql = $pdo->prepare("INSERT INTO activity VALUES (null, ?, ?)");
                $sql->execute(array($atv, 0));
            }
        ?>

        <?php 
            if(isset($_POST["acao"])){
                $activity = $_POST["activity"];
                $ids = $_POST["id"];
                $pdo = new PDO("mysql:host=localhost;dbname=todo", "root", "");
                foreach ($ids as $key => $value) {

                    if($value == 0 && $key != 0){
                        $sql = $pdo->prepare("UPDATE `activity` SET done=0 WHERE id=?");
                        $sql->execute(array($key));
                    }
                    else if($value == 1 && $key != 0){
                        $sql = $pdo->prepare("UPDATE `activity` SET done=1 WHERE id=?");
                        $sql->execute(array($key));
                    }
                }
            }
        ?>

        <?php 
            if(isset($_POST["remove"])){
                $ids = $_POST["delete_id"];
                $pdo = new PDO("mysql:host=localhost;dbname=todo", "root", "");
                foreach($ids as $key => $value){
                    if($value == 1 && $key != 0){
                        $sql = $pdo->prepare("DELETE FROM `activity` WHERE id=?");
                        $sql->execute(array($key));
                    }
                }
            }
        ?>

        <form method="post">
            <table>
                <thead>
                    <th>Done?</th>
                    <th>Delete?</th>
                    <th>Activity</th>
                </thead>
                <tbody id="tbody">
                    <?php 
                        $pdo = new PDO("mysql:host=localhost;dbname=todo", "root", "");
                        $sql = $pdo->prepare("SELECT * from activity");
                        $sql->execute();
                        $activities = $sql->fetchAll();

                        foreach ($activities as $key => $value) {
                            echo "<tr>";
                            if($value["done"] == 0){
                                echo "<td class='hidden'><input type='hidden' name='id[".$value["id"]."]' value=0 </td>";
                                echo "<td><input type='checkbox' name='id[".$value["id"]."]' value=1 </td>";
                                echo "<td class='hidden'><input type='hidden' name='delete_id[".$value["id"]."]' value=0 </td>";
                                echo "<td><input type='checkbox' name='delete_id[".$value["id"]."]' value=1 </td>";
                            }else{
                                echo "<td class='hidden'><input type='hidden' name='id[".$value["id"]."]' value=0 </td>";
                                echo "<td><input type='checkbox' checked name='id[".$value["id"]."]' value=1 </td>";
                                echo "<td class='hidden'><input type='hidden' name='delete_id[".$value["id"]."]' value=0 </td>";
                                echo "<td><input type='checkbox' name='delete_id[".$value["id"]."]' value=1 </td>";
                            }
                            echo "<td>".$value["activity"]."</td>";
                            echo "</tr>";
                        }
                    ?>
                
                </tbody>
            </table>
            <div class="center">
                <input type="submit" value="Update dones" name="acao">
                <input type="submit" value="Delete selections" name="remove">
            </div>
        </form>
        </section>
    </main>
    <footer></footer>
    <script src="js/script.js"></script>
</body>

</html>
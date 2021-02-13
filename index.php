<?php
    require('database.php');

    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
    <h1>To Do List</h1>
    </header>
    <main>
        <?php

            if($title) {
                $insert_query = "INSERT INTO todoitems (title, description)
                                    VALUES (:title, :description)";
                $statement = $db->prepare($insert_query);
                $statement->bindvalue(":title", $title);
                $statement->bindvalue(":description", $description);
                $statement->execute();
                $statement->closeCursor();
                unset($title);
                unset($description);
            }

            $select_query = "SELECT * FROM todoitems
                        ORDER BY itemnum";
            $statement = $db->prepare($select_query);
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();

        ?>
        <section class="results">
            <?php
                if(!empty($results)) {
                    foreach($results as $result) {
                        $rid = $result["ItemNum"];
                        $rtitle = $result["Title"];
                        $rdesc = $result["Description"];
            ?>
                <div class="card">
                    <form class="complete" action="delete_item.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $rid ?>">
                        <button type="submit" class="complete-button"></button>
                    </form>
                    <h3>
                        <?php echo $rtitle ?>
                    </h3>
                    <p>
                        <?php echo $rdesc ?>
                    </p>
                </div>
            <?php }} else {} ?>
        </section>
        <section class="add">
            <h2>Add Item</h2>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                <input type="text" name="title" id="title" placeholder="Title" required>
                <br>
                <input type="text" name="description" id="description" placeholder="Description" required>
                <br>
                <button type="submit">Add</button>
            </form>
        </section>
    </main>
    <footer>

    </footer>
    
</body>
</html>
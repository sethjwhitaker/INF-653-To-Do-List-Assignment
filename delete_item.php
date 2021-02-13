<?php 
    require('database.php');

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if($id) {
        $query = "DELETE FROM todoitems WHERE itemnum = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }

    $deleted = true;

    include('index.php');
    header("Location: .");
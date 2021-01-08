<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$stmt = $category->findAll();
$num = $stmt->rowCount();

if ($num > 0) {
    $categories = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "created" => $created,
            "modified" => $modified
        );

        array_push($categories, $category_item);
    }
    http_response_code(200);
    echo json_encode($categories);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No category found.")
    );
}

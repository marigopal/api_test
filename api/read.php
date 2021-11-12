<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/employees.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Employee($db);

    $stmt = $items->getEmployees();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);
    $status = '500';
    if($itemCount > 0){
        
        $employeeArr = array();
      
       

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "age" => $age,
                "designation" => $designation,
                "created" => $created
            );

            
        }
        $response['status'] = '500';
        $response['response'] = $e;
        $response['message'] = 'Record Found';
       echo json_encode($response);
       
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
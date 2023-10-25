<?php
session_start();

    if (!isset($_SESSION['data'])) {
        $_SESSION['data'] = '<tr></tr>';
        $_SESSION['id'] = 0;
    }
function check($x, $y, $r){
    if($x <= 0 && $x >= (-$r) && $y >=0 && $y <= $r){
        return "Попал";
    }
    else if($x >= 0 && $x <= ($r / 2) && $y >= 0 && $y < $r ){
        if($y + 2 * $x <= $r){
            return "Попал";
        }
    }
    else if($x <= 0 && $y <= 0) {
        if ($x < (-$r)){
            return "Не попал";
        }
         if(($x * $x) + ($y * $y) <= ($r * $r)) {
            return "Попал";
        }

    }
    return "Не попал";
}

    function get_data(){
        return $_SESSION["data"];
    }


/**
 * @throws Exception
 */
function set_data(){
        $time_start = microtime(true);
        $timezone = new DateTimeZone('Europe/Moscow');
        $date = new DateTime('now', $timezone);

        $x = $_POST["x"];
        $y = $_POST["y"];
        $r = $_POST["r"];
        $res = '
                    <tr class="data">
                        <td>' . ++$_SESSION["id"] . '</td>
                        <td>' . $x . '</td>
                        <td>' . $y . '</td>
                        <td>' . $r . '</td>
                        <td>' . check($x, $y, $r) . '</td>
                        <td>' . $date->format('Y-m-d H:i:s') . '</td>
                        <td>' . (microtime(true) - $time_start) * 1000 . '</td>
                    </tr>';

            $_SESSION['id'] = $_SESSION["id"];
        $_SESSION['data'] = $_SESSION["data"] . $res;

        return $res;
    }

        function reset_data(){
            $_SESSION['data'] = '<tr></tr>';
            $_SESSION['id'] = 0;
        }


$req = $_POST["req"];

    if($req == "get_data") echo json_encode(get_data());
    else if($req == "set_data") try {
        echo json_encode(set_data());
    } catch (Exception $e) {
    }
    else if($req == "reset_data") reset_data();
?>
















<?php
    $total_data = array(
        'n' => rand(0,999)
        );
    echo $_get['jsonp'].'('. json_encode($total_data) . ')';
?>
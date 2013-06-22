<?php

function varJS($name, $value) {

    echo "<script>"; 
    
    echo "var " . $name . " = '" . $value . "';";
    
    echo "</script>"; 

}

function arrJS($name, $value) {

    echo "<script>"; 
    
    echo "var " . $name . " = " . $value . ";";
    
    echo "</script>"; 

}

?>

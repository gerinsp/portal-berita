<?php 

function splitName($name)
{
    $splitName = explode(' ', $name, 2);
    $first_name = $splitName[0];

    return $first_name;
}

?>
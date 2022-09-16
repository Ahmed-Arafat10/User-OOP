<?php
session_start();
function IsLoggedIn()
{
    if(isset($_SESSION['userdata'])) return 1;
    return 0;
}

<?php
session_start();

/* 
    Sam: Este es un archivo nuevo que se tiene que agregar al proyecto, 
    este es para que funcione el apartado cerrar sesion en la pagina web
     si no se agrega, la funcion (Cerrar Sesion) logout, no va a funcionar.
*/ 

// Sam: Aqui destruir todas las variables de sesión
$_SESSION = array();

/*
 Sam: aqui es para destruir (Cerrar Sesion) la sesión completamente, borra también la cookie de sesión
 esto es para cerrar la sesion del lado del servidor asi como del lado del navegador
*/
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Sam: aqui finalmente se destruye la sesión OJO, no se borra solo se cierra por completo.
session_destroy();

// Sam: Redirigir al login (Regresa a la pagina de para ingresar los datos del usuario desdpues de cerrar sesion).
header("Location: login.html");
exit();
?>
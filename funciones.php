<?php
class HolaMundo
{
private $nombre;
function __construct($nombre)
{
$this->nombre = $nombre;
}
function __toString()
{
return sprintf ("Hola, %s.\n", $this->nombre);
}
}
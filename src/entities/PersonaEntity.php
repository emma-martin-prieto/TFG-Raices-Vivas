<?php
namespace RaicesVivas\Entities;

class PersonaEntity {

    private string  $codigo;
    private string  $nombre;
    private string  $priApe;
    private ?string $segApe;
    private string  $fechaNacimiento;
    private string  $email;
    private int     $idLocalidad;

    // ── Getters
    public function getCodigo():          string  { return $this->codigo; }
    public function getNombre():          string  { return $this->nombre; }
    public function getPriApe():          string  { return $this->priApe; }
    public function getSegApe():          ?string { return $this->segApe; }
    public function getFechaNacimiento(): string  { return $this->fechaNacimiento; }
    public function getEmail():           string  { return $this->email; }
    public function getIdLocalidad():     int     { return $this->idLocalidad; }

    // ── Setters
    public function setCodigo(string $codigo):            static { $this->codigo = $codigo;                   return $this; }
    public function setNombre(string $nombre):            static { $this->nombre = $nombre;                   return $this; }
    public function setPriApe(string $priApe):            static { $this->priApe = $priApe;                   return $this; }
    public function setSegApe(?string $segApe):           static { $this->segApe = $segApe;                   return $this; }
    public function setFechaNacimiento(string $fecha):    static { $this->fechaNacimiento = $fecha;           return $this; }
    public function setEmail(string $email):              static { $this->email = $email;                     return $this; }
    public function setIdLocalidad(int $idLocalidad):     static { $this->idLocalidad = $idLocalidad;         return $this; }
}
<?php

namespace RaicesVivas\Entities;

class ActividadEntity
{

    private int    $id;
    private string $nombre;
    private string $tipo;
    private string $descripcionGeneral;
    private float  $precio;
    private int    $duracion;
    private string $estado;
    private ?string $motivoCancelacion;
    private int    $idOrganizador;

    // Getters
    public function getId(): int{
        return $this->id;
    }
    public function getNombre(): string{
        return $this->nombre;
    }
    public function getTipo(): string{
        return $this->tipo;
    }
    public function getDescripcionGeneral(): string{
        return $this->descripcionGeneral;
    }
    public function getPrecio(): float{
        return $this->precio;
    }
    public function getDuracion(): int{
        return $this->duracion;
    }
    public function getEstado(): string{
        return $this->estado;
    }
    public function getMotivoCancelacion(): ?string{
        return $this->motivoCancelacion;
    }
    public function getIdOrganizador(): int{
        return $this->idOrganizador;
    }

    // Setters (devuelven $this para encadenar)
    public function setId(int $id): static{
        $this->id = $id;
        return $this;
    }
    public function setNombre(string $nombre): static{
        $this->nombre = $nombre;
        return $this;
    }
    public function setTipo(string $tipo): static{
        $this->tipo = $tipo;
        return $this;
    }
    public function setDescripcionGeneral(string $desc): static{
        $this->descripcionGeneral = $desc;
        return $this;
    }
    public function setPrecio(float $precio): static{
        $this->precio = $precio;
        return $this;
    }
    public function setDuracion(int $duracion): static{
        $this->duracion = $duracion;
        return $this;
    }
    public function setEstado(string $estado): static{
        $this->estado = $estado;
        return $this;
    }
    public function setMotivoCancelacion(?string $motivo): static{
        $this->motivoCancelacion = $motivo;
        return $this;
    }
    public function setIdOrganizador(int $idOrg): static{
        $this->idOrganizador = $idOrg;
        return $this;
    }
}

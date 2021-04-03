<?php


namespace App\Http\Traits;


trait Importable
{
    public function getFillableForImport(): array {
        return (isset($this->importFillable))
            ? array_merge($this->fillable, $this->importFillable)
            : $this->fillable;
    }
}

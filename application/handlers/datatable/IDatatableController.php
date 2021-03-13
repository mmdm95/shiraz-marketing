<?php

interface IDatatableController
{
    /**
     * @param array $_
     * @return void
     */
    public function getPaginatedDatatable(...$_): void;
}
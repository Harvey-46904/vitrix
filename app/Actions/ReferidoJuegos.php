<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ReferidoJuegos extends AbstractAction
{
    public function getTitle()
    {
        return 'Referidos';
    }

    public function getIcon()
    {
        return 'voyager-bubble-heare';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'juegos';
    }

   

    public function getDefaultRoute()
    {
        return route('RentabilidadGame',  $this->data->id);
    }
}
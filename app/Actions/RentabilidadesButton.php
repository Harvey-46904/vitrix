<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class RentabilidadesButton extends AbstractAction
{
    public function getTitle()
    {
        return 'Rentabilidades';
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
        return $this->dataType->slug == 'inversiones';
    }

   

    public function getDefaultRoute()
    {
        return route('RentabilidadesList',  $this->data->id);
    }
}
<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ApuestasButton extends AbstractAction
{
    public function getTitle()
    {
        return 'Apuestas';
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
        return $this->dataType->slug == 'salas';
    }

   

    public function getDefaultRoute()
    {
        return route('apuestasunicas',  $this->data->id);
    }
}
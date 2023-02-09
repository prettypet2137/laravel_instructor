<?php

namespace Modules\Core\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        return auth()->user()->id;
    }

    public function baseDirectory(){
        return 'storage/users/'.auth()->user()->id;
    }
}

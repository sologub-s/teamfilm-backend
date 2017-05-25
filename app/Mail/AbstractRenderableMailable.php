<?php
/**
 * Created by PhpStorm.
 * User: zeitgeist
 * Date: 5/25/17
 * Time: 3:17 PM
 */

namespace App\Mail;

use Illuminate\Mail\Mailable;

abstract class AbstractRenderableMailable extends Mailable
{
    public function render() {
        $this->build();
        return app()->make('view')->make($this->buildView(), $this->buildViewData())->render();
    }
}
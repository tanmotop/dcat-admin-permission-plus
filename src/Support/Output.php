<?php


namespace Tanmo\Dcat\Permission\Support;


class Output
{
    public function header()
    {
        header('X-Accel-Buffering: no');
    }

    public function output($msg)
    {
        echo "<script>parent.displayMsg(\"{$msg}\");</script>";
        ob_flush();
        flush();
        usleep(10000);
    }

    public function end()
    {
        ob_end_flush();
    }
}

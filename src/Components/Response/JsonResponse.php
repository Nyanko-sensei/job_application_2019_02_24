<?php

namespace JobApplication_2019_02_24\Components\Response;

use JobApplication_2019_02_24\Interfaces\Response;

class JsonResponse implements Response
{
    /**
     * @param string $msg
     *
     * @return mixed
     */
    public function fail(string $msg)
    {
        $this->init();
        $payload = [
            'sucsess' => 0,
            'msg' => $msg,
        ];
        echo(json_encode($payload));
        die();
    }

    /**
     * @param array $payload
     *
     * @return mixed
     */
    public function success(array $payload)
    {
        $this->init();
        echo(json_encode($payload));
        die();
    }

    private function init()
    {
        header('Content-Type: application/json');
    }
}
<?php

class DefaultController extends Controller
{
    public function index()
    {
        $this->data['raw_data'] = true;
        $this->data[] = 'something to write';
    }
}
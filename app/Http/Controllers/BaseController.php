<?php

    namespace App\Http\Controllers;


    class BaseController extends Controller
    {
        protected $service;

        public function set_service( $service): void
        {
            $this->service = $service;
        }

    }

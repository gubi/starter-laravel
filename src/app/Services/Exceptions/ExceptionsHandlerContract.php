<?php
namespace Zikkio\Services\Exceptions;

use Exception;

interface ExceptionsHandlerContract
{
    public function renderException($request, Exception $exception);

    public function reportException(Exception $exception);
}
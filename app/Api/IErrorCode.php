<?php


namespace App\Api;


interface IErrorCode
{
    function getCode(): int;

    function getMessage(): string;
}

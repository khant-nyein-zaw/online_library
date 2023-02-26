<?php

namespace App\Enums;

enum IssuedBookStatus: string
{
    case Issued = "issued";
    case Returned = "returned";
    case NotReturned = "not_returned";
}

<?php
namespace App\Enum;

enum Status: string {
    case CREATED = 'created';
    case VISIBLE = 'visible';
    case ARCHIVED = 'archived';
    case CANCELLED = 'cancelled';
}
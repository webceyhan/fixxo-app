<?php

namespace App\Models;

use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, Searchable;

    /**
     * Index to use for full text search.
     *
     * @var string
     */
    protected $searchIndex = 'notes';
}

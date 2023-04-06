<?php

namespace BrankoDragovic\Webhook\Tests\Model;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test_table';
    protected $fillable = ['name', 'email', 'password'];
}

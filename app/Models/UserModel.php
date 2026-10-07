<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'registration';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'email',
        'password',
        'first_name',
        'last_name',
        'middle_name',
        'birthday',
        'gender',
        'phone_number',
        'address',
        'department',
    ];
}

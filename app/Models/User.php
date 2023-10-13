<?php

namespace Laramus\Liberius\Models;
use Laramus\Liberius\Ancient\Model;

/**
 * Class User
 * 
 * Model for class User
 */
class User extends Model
{
    private $db;

    public function getActiveUsers() {
        return $this->getAll();
    }

    /**
     * 
     * @return array
     */
}

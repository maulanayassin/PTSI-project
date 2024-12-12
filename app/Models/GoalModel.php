<?php

namespace App\Models;

use CodeIgniter\Model;

class GoalModel extends Model
{
    protected $table = 'goal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['goal', 'goal_name'];
}
?>
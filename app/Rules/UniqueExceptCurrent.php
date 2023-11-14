<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueExceptCurrent implements Rule
{
    protected $table;
    protected $column;
    protected $currentValue;
    protected $exceptColumn;
    protected $exceptValue;

    public function __construct($table, $column, $currentValue, $exceptColumn, $exceptValue)
    {
        $this->table = $table;
        $this->column = $column;
        $this->currentValue = $currentValue;
        $this->exceptColumn = $exceptColumn;
        $this->exceptValue = $exceptValue;
    }

    public function passes($attribute, $value)
    {
        $result = DB::table($this->table)
            ->where($this->column, $value)
            ->where($this->exceptColumn, '!=', $this->exceptValue)
            ->count();

        return $result === 0;
    }

    public function message()
    {
        return 'Nilai tidak boleh duplicat.';
    }
}

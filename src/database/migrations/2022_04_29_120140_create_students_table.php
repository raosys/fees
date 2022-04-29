<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = $this->getTableName();
        if (!Schema::hasTable($name)) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('StudentName');
                $table->string('StudentEmail')->unique();
                $table->string('StudentRegNumber')->unique();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName());
    }

    private function getTableName()
    {
        $studentModel = config('fees.student_model');
        return (new $studentModel())->getTable();
    }
}

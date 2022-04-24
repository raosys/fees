<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;

class CreateFeePackageCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->getTableName())) {
            $nameColumn = config('fees.course_table_columns')['name']; // is_array(config('fees.course_table_columns')) ?  config('fees.course_table_columns')['name'] : "name";
            $short_nameColumn = config('fees.course_table_columns')['short_name']; //is_array(config('fees.course_table_columns')) ?   config('fees.course_table_columns')['short_name'] : "short_name";
            Schema::create($this->getTableName(), function (Blueprint $table) use ($nameColumn, $short_nameColumn) {
                $table->id();
                $table->string($nameColumn)->unique();
                $table->string($short_nameColumn)->unique();
                $table->timestamps();
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
        Schema::dropIfExists('courses');
    }

    private function getTableName()
    {
        $userModel = is_array(config('fees.courses_model')) ? config('fees.courses_model')[intval(App::version())] : config('fees.courses_model');
        return (new $userModel())->getTable();
    }
}

<?php namespace Octommerce\Octommerce\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCurrenciesTable extends Migration
{

    public function up()
    {
        Schema::create('octommerce_octommerce_currencies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('octommerce_octommerce_currencies');
    }

}

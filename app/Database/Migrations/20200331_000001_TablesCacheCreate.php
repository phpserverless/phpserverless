<?php

class TablesCacheCreate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Plugins\CachePlugin::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Plugins\CachePlugin::deleteTables();
    }
}
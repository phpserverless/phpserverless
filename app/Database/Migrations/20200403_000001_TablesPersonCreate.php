<?php

class TablesPersonCreate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Plugins\PersonPlugin::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Plugins\PersonPlugin::deleteTables();
    }
}
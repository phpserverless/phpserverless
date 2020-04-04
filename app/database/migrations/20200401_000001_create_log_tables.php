<?php

class CreateLogTables
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Plugins\LogPlugin::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Plugins\LogPlugin::deleteTables();
    }
}
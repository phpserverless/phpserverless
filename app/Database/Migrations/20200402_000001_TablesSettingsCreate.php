<?php

class TablesSettingsCreate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Plugins\SettingsPlugin::createTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Plugins\SettingsPlugin::deleteTables();
    }
}
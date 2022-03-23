<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateScriptsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE VIEW `vw_script` AS
                select 
                id,
                filename,
                if(description is null, 
                    filename,
                if(trim(description)='',filename, description)) as description,
                version,
                state
                from scripts"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW IF EXISTS vw_script' );
    }
}

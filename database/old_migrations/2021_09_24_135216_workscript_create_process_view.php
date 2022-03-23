<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WorkscriptCreateProcessView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE VIEW `ws_vw_process` AS
                select 
                    p.id as id,
                    p.category_id as category_id,
                    c.name as category_name,
                    p.name as process_name,
                    p.active as active,
                    p.diagram as diagram,
                    pub.version as version,
                    pub.created_at as published_at,
                    p.update_at as update_at
                from ws_process p 
                        left join ws_category c on (p.category_id=c.id)
                        left join ws_published pub on (pub.id=p.published_id)"
        );
        
        
        DB::statement(
            "CREATE VIEW `ws_vw_process_security` AS
                select 
                    p.id as id,
                    p.category_id as category_id,
                    p.category_name as category_name,
                    p.process_name as process_name,
                    p.active as active,
                    p.diagram as diagram,
                    p.version as version,
                    p.published_at as published_at,
                    p.update_at as update_at,
                    u.id as user_id,
                    u.name as user_name,
                    u.email as user_email
                from ws_vw_process p 
                        inner join ws_security s on (p.id=s.process_id)
                        left join users u on (u.id=s.user_id)"
        );
        
        
        DB::statement(
            "CREATE VIEW `ws_vw_elements_x_flow` AS
                select
                    e.id as id,
                    e.process_id as process_id,
                    e.type as element_type,
                    e.name as element_name,
                    e.processing as processing,
                    e.instance as instance,
                    f.id as flow_id,
                    f.type as flow_type,
                    f.interrupting as flow_interrupting,
                    f.follow_id as follow_id,
                    f2.name as follow_name,
                    f2.type as follow_type
                from ws_elements e
                        left join ws_elements_flow f on (f.element_id=e.id)
                        left join ws_elements f2 on (f.follow_id=f2.id)"
        );
    
        
        DB::statement(
            "CREATE VIEW `ws_vw_elements_flow` AS
                select 
                    f.id as id,
                    f.element_id as element_id,
                    f.type as flow_type,
                    f.interrupting as interrupting,
                    f.follow_id as follow_id,
                    f2.name as follow_name,
                    f2.type as follow_type
                from ws_elements_flow f
                        left join ws_elements f2 on (f.follow_id=f2.id)"
        );
    
        
        DB::statement(
            "CREATE VIEW `ws_vw_elements_waiting` AS
                select 
                    w.id as id,
                    w.element_id as element_id,
                    w.waiting_id as waiting_id,
                    w2.type as waiting_type,
                    w2.name as waiting_name
                from ws_elements_waiting w
                        left join ws_elements w2 on (w.waiting_id=w2.id)"
        );
    
        
        // DB::statement(
        //     "CREATE VIEW `ws_vw_elements_distributions` AS
        //         select 
        //             d.id as id,
        //             e.process_id as process_id,
        //             d.element_id as element_id,
        //             e.type as element_type,
        //             e.name as element_name,
        //             d.group_id as group_id,
        //             g.description as group_description,
        //             d.operation as operation
        //         from ws_elements_distributions d
        //                 inner join ws_elements e on (d.element_id=e.id)
        //                 left join x_groups g on (d.group_id=g.group_id)"
        // );
    
        
        // DB::statement(
        //     "CREATE VIEW `ws_vw_elements_operations` AS
        //         select 
        //             o.id as id,
        //             e.process_id as process_id,
        //             o.element_id as element_id,
        //             e.type as element_type,
        //             e.name as element_name,
        //             o.group_id as group_id,
        //             g.description as group_description,
        //             o.operation as operation
        //         from ws_elements_operations o
        //                 inner join ws_elements e on (o.element_id=e.id)
        //                 left join x_groups g on (o.group_id=g.group_id)"
        // );
        
    
        DB::statement(
            "CREATE VIEW `ws_vw_published` AS
                select 
                    pb.id as id,
                    pb.process_id as process_id,
                    pb.category_name as category_name,
                    pb.name as process_name,
                    pb.version as version,
                    pb.created_at as created_at,
                    if(p.id is null, 'no', 'yes') as published_default
                from ws_published pb
                        left join ws_process p on (p.published_id=pb.id)"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_process' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_process_security' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_elements_x_flow' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_elements_flow' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_elements_waiting' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_elements_distributions' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_elements_operations' );
        DB::statement( 'DROP VIEW IF EXISTS ws_vw_published' );
    }
}

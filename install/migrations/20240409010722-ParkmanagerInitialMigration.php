<?php

class ParkmanagerInitialMigration extends CmfiveMigration
{
    public function up()
    {
        // UP
        $column = parent::Column();
        $column->setName('id')
                ->setType('biginteger')
                ->setIdentity(true);

        if (!$this->hasTable("park_manager_bookings")) {
            $this->table("park_manager_bookings", [
                "id" => false,
                "primary_key" => "id"
            ])->addColumn($column)
				->addColumn('numofguests', 'biginteger')
                ->addDateTimeColumn('dt_bookingtime')
                ->addDateTimeColumn('dt_startofstaydate')
                ->addDateTimeColumn('dt_endofstaydate')
                ->addMoneyColumn('totalcost')
                ->addMoneyColumn('rate')
                ->addMoneyColumn('remainingcost')
                ->addCmfiveParameters()
                ->create();
        }

        if (!$this->hasTable("site")) {
            $this->table("site", [
                "id" => false,
                "primary_key" => "id"
            ])->addColumn($column)
                ->addIdColumn('booking_id') //dt_DayTrack
                ->addStringColumn('sitename')
                ->addBooleanColumn('has_electricity')
                ->addBooleanColumn('is_booked')
                ->addBooleanColumn('is_closed')
                ->addCmfiveParameters()
                ->create();
        }

        if (!$this->hasTable("park_guest")) {
            $this->table("park_guest", [
                "id" => false,
                "primary_key" => "id"
            ])->addColumn($column)
                ->addIdColumn('contact_id') //dt_DayTrack
                ->addIdColumn('booking_id')
                ->addIdColumn('site_id')
                // ->addMoneyColumn('balance')
                // ->addMoneyColumn('totalcost')
                ->addCmfiveParameters()
                ->create();
        }

        if (!$this->hasTable("settings")) {
            $this->table("settings", [
                "id" => false,
                "primary_key" => "id"
            ])->addColumn($column)
                ->addStringColumn('mapfilepath')
                ->addCmfiveParameters()
                ->create();
        }
    }

    public function down()
    {
        $this->hasTable('park_manager_bookings') ? $this->dropTable('park_manager_bookings') : null;
        $this->hasTable('site') ? $this->dropTable('site') : null;
        $this->hasTable('park_guest') ? $this->dropTable('park_guest') : null;
        $this->hasTable('settings') ? $this->dropTable('settings') : null;
        // DOWN
    }

    public function preText()
    {
        return null;
    }

    public function postText()
    {
        return null;
    }

    public function description()
    {
        return null;
    }
}

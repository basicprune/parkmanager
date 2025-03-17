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

        if (!$this->hasTable("parkmanager_bookings")) {
            $this->table("parkmanager_bookings", [
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

        if (!$this->hasTable("parkmanager_site")) {
            $this->table("parkmanager_site", [
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

        if (!$this->hasTable("parkmanager_guest")) {
            $this->table("parkmanager_guest", [
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
    }

    public function down()
    {
        $this->hasTable('parkmanager_bookings') ? $this->dropTable('parkmanager_bookings') : null;
        $this->hasTable('parkmanager_site') ? $this->dropTable('parkmanager_site') : null;
        $this->hasTable('parkmanager_guest') ? $this->dropTable('parkmanager_guest') : null;
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

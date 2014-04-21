<?php

class m140227_133110_create_admin_user extends CDbMigration
{
	public function up()
	{

	    $user_name         = 'admin@florida.com';
	    $user_password     = 'crikey3';

	    $password_hash     =  CPasswordHelper::hashPassword($user_password);

	    $this->execute( "SET foreign_key_checks = 0");

	    $this->insert('tbl_user',
	        array( 'user_name'             => $user_name,
	    	       'email'                 => $user_name,
	               'password'              => $password_hash,
	               'first_name'            => 'Root',
	               'last_name'             => 'Admin User',
	               'user_type'             => 'superadmin',
	               'status'                => 'active',
	               'activation_status'     => 'activated',
	             )
	    );

	    $this->execute( "SET foreign_key_checks = 1");

	}

	public function down()
	{
		echo "m140227_133110_create_admin_user does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
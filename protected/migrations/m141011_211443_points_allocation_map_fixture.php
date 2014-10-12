<?php

class m141011_211443_points_allocation_map_fixture extends CDbMigration
{
	public function up()
	{

	    $this->insert('tbl_points_allocation_map',array('event'=> 'POST_QUESTION',  'points'=>10, 'description' => 'Post question'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'INVITE_FRIENDS', 'points'=>10, 'description' => 'Friends invited'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'FRIENDS_JOINED', 'points'=>10, 'description' => 'Friends joined'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'ADD_IMAGE', 'points'=>10, 'description' => 'Add  image'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'REPORT_HOTEL_VIOLATION', 'points'=>10, 'description' => 'Report a violation'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'HOTEL_REVIEW', 'points'=>10, 'description' => 'for hotel reviews'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'BUSINESS_REVIEW', 'points'=>10, 'description' => 'for all other reviews'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'TINY_REVIEW', 'points'=>10, 'description' => 'if review has fewer than 75 characters'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'STAR_RATING_ONLY', 'points'=>10, 'description' => 'for star ratings only'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'FIRST_TO_REVIEW', 'points'=>10, 'description' => 'for being the first to review'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'VISIT_SITE', 'points'=>10, 'description' => 'Visit the Site'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'SOMETHING_WAS_LIKED', 'points'=>10, 'description' => 'Something of Yours Was Liked'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'RECOMMENDATION_WAS_HELPFUL', 'points'=>10, 'description' => 'Your Recommendation Got a Helpful Vote'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'POST_RANT', 'points'=>10, 'description' => 'make a rant '));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'POST_ANSWER', 'points'=>10, 'description' => 'answer a question'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'POPULAR_QUESTION', 'points'=>10, 'description' => 'popular question  100 views'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'FAVORITE_QUESTION', 'points'=>10, 'description' => 'favorite  question ( ?)'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'NICE_QUESTION', 'points'=>10, 'description' => 'nice question  --- gets  thumbs up'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'COMPLETE_PROFILE', 'points'=>10, 'description' => 'completed  about me'));
	    $this->insert('tbl_points_allocation_map',array('event'=> '10_COMMENTS_WITH_THUMBS_UP', 'points'=>10, 'description' => 'left 10 comments  with  thumbs up'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'POST_FLAG_NOT_HELPFUL', 'points'=>10, 'description' => '5 people  think post  was not helpful'));
	    $this->insert('tbl_points_allocation_map',array('event'=> 'PHONY_REVIEW', 'points'=>10, 'description' => 'phony review'));

	}

	public function down()
	{
		$this->truncateTable('tbl_points_allocation_map');
		return true;
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
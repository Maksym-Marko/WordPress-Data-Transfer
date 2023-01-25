<?php 
global $wpdb;

/**
 *  posts
 * */
/*
$posts = $wpdb->get_results( "SELECT ID,
post_author,
post_date,
post_date_gmt,
post_content,
post_title,
post_excerpt,
post_status,
comment_status,
post_name,
post_modified,
post_modified_gmt,
post_parent,
post_type,
comment_count FROM wp_posts WHERE post_type = 'post' AND post_status = 'publish'" );

// write files
$output = [];

$header = [
	'ID',
	'post_author',
	'post_date',
	'post_date_gmt',
	'post_content',
	'post_title',
	'post_excerpt',
	'post_status',
	'comment_status',
	'post_name',
	'post_modified',
	'post_modified_gmt',
	'post_parent',
	'post_type',
	'comment_count'
];

array_push( $output, $header );

foreach( $posts as $post ) {	

	$row = [
		$post->ID,
		$post->post_author,
		$post->post_date,
		$post->post_date_gmt,
		$post->post_content,
		$post->post_title,
		$post->post_excerpt,
		$post->post_status,
		$post->comment_status,
		$post->post_name,
		$post->post_modified,
		$post->post_modified_gmt,
		$post->post_parent,
		$post->post_type,
		$post->comment_count
	];

	array_push( $output, $row );

}

$list = $output;

$file_posts = __DIR__ . '\export\posts.csv';

$fp = fopen( $file_posts, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

var_dump(count($posts));
*/

/**
 *  postmeta
 * */
/*
$postmeta = $wpdb->get_results( "SELECT meta_id,
post_id,
meta_key,
meta_value FROM wp_postmeta 
    WHERE meta_key = '_thumbnail_id' OR 
            meta_key = '_wp_attached_file' OR 
            meta_key = '_wp_attachment_metadata'
" );

// write files
$output = [];

$header = [
	'meta_id',
	'post_id',
	'meta_key',
	'meta_value'
];

array_push( $output, $header );

foreach( $postmeta as $meta ) {
	
	$meta_id = $meta->meta_id;
	$post_id = $meta->post_id;
	$meta_key = $meta->meta_key;
	$meta_value = $meta->meta_value;

	$row = [
		$meta_id,
		$post_id,
		$meta_key,
		$meta_value
	];

	array_push( $output, $row );

}


$list = $output;

$file_postmeta = __DIR__ . '\export\postmeta.csv';

$fp = fopen( $file_postmeta, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

var_dump(count($postmeta));
*/


/**
 *  users
 * */
/*
$users = $wpdb->get_results( "SELECT ID,
user_login,
user_pass,
user_nicename,
user_email,
user_url,
user_registered,
user_activation_key,
user_status,
display_name FROM wp_users" );

// write files
$output = [];

$header = [
	'ID',
	'user_login',
	'user_pass',
	'user_nicename',
	'user_email',
	'user_url',
	'user_registered',
	'user_activation_key',
	'user_status',
	'display_name'
];

array_push( $output, $header );

foreach( $users as $user ) {	

	$row = [
		$user->ID,
		$user->user_login,
		$user->user_pass,
		$user->user_nicename,
		$user->user_email,
		$user->user_url,
		$user->user_registered,
		$user->user_activation_key,
		$user->user_status,
		$user->display_name
	];

	array_push( $output, $row );

}

$list = $output;

$file_users = __DIR__ . '\export\users.csv';

$fp = fopen( $file_users, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/

/**
 *  Comments
 * */
/*
$comments = $wpdb->get_results( "SELECT * FROM wp_comments WHERE comment_approved='1' AND comment_type='comment'" );

// write files
$output = [];

$header = [
	'comment_ID',
	'comment_post_ID',
	'comment_author',
	'comment_author_email',
	'comment_author_url',
	'comment_author_IP',
	'comment_date',
	'comment_date_gmt',
	'comment_content',
	'comment_karma',
	'comment_approved',
	'comment_agent',
	'comment_type',
	'comment_parent',
	'user_id'
];

array_push( $output, $header );

foreach( $comments as $comment ) {	

	$row = [
		$comment->comment_ID,
		$comment->comment_post_ID,
		$comment->comment_author,
		$comment->comment_author_email,
		$comment->comment_author_url,
		$comment->comment_author_IP,
		$comment->comment_date,
		$comment->comment_date_gmt,
		$comment->comment_content,
		$comment->comment_karma,
		$comment->comment_approved,
		$comment->comment_agent,
		$comment->comment_type,
		$comment->comment_parent,
		$comment->user_id
	];

	array_push( $output, $row );

}

$list = $output;

$file_comments = __DIR__ . '\export\comments.csv';

$fp = fopen( $file_comments, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

var_dump(count($comments));
*/

/**
 *  Attachments
 * */
/*
$attachments = $wpdb->get_results( "SELECT ID,
post_author,
post_date,
post_date_gmt,
post_content,
post_title,
post_excerpt,
post_status,
comment_status,
post_name,
post_modified,
post_modified_gmt,
post_parent,
post_type,
comment_count FROM wp_posts WHERE post_type = 'attachment'" );

// write files
$output = [];

$header = [
	'ID',
	'post_author',
	'post_date',
	'post_date_gmt',
	'post_content',
	'post_title',
	'post_excerpt',
	'post_status',
	'comment_status',
	'post_name',
	'post_modified',
	'post_modified_gmt',
	'post_parent',
	'post_type',
	'comment_count'
];

array_push( $output, $header );

foreach( $attachments as $post ) {	

	$row = [
		$post->ID,
		$post->post_author,
		$post->post_date,
		$post->post_date_gmt,
		$post->post_content,
		$post->post_title,
		$post->post_excerpt,
		$post->post_status,
		'closed',//$post->comment_status,
		$post->post_name,
		$post->post_modified,
		$post->post_modified_gmt,
		$post->post_parent,
		$post->post_type,
		0,//$post->comment_count
	];

	array_push( $output, $row );

}

$list = $output;

$file_attachments = __DIR__ . '\export\attachments.csv';

$fp = fopen( $file_attachments, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

var_dump(count($attachments));
*/

/**
 *  Terms
 * */
/*
$terms = $wpdb->get_results( "SELECT * FROM wp_terms" );

// write files
$output = [];

$header = [
	'term_id',
	'name',
	'slug',
	'term_group'
];

array_push( $output, $header );

foreach( $terms as $term ) {	

	$row = [
		$term->term_id,
		$term->name,
		$term->slug,
		$term->term_group,
	];

	array_push( $output, $row );

}

$list = $output;

$file_terms = __DIR__ . '\export\terms.csv';

$fp = fopen( $file_terms, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/

/**
 *  Termmeta
 * */
/*
$termmeta = $wpdb->get_results( "SELECT * FROM wp_termmeta" );

// write files
$output = [];

$header = [
	'meta_id',
	'term_id',
	'slug',
	'term_group'
];

array_push( $output, $header );

foreach( $termmeta as $term ) {	

	$row = [
		$term->meta_id,
		$term->term_id,
		$term->meta_key,
		$term->meta_value,
	];

	array_push( $output, $row );

}

$list = $output;

$file_termmeta = __DIR__ . '\export\termmeta.csv';

$fp = fopen( $file_termmeta, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/

/**
 *  Term_relationships
 * */

/*
$termmeta = $wpdb->get_results( "SELECT * FROM wp_term_relationships" );

// write files
$output = [];

$header = [
	'object_id',
	'term_taxonomy_id',
	'term_order',
];

array_push( $output, $header );

foreach( $termmeta as $term ) {	

	$row = [
		$term->object_id,
		$term->term_taxonomy_id,
		$term->term_order,
	];

	array_push( $output, $row );

}

$list = $output;

$file_termmeta = __DIR__ . '\export\term_relationships.csv';

$fp = fopen( $file_termmeta, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/


/**
 *  Term_taxonomy
 * */

/*
$termmeta = $wpdb->get_results( "SELECT * FROM wp_term_taxonomy" );

// write files
$output = [];

$header = [
	'term_taxonomy_id',
	'term_id',
	'taxonomy',
	'description',
	'parent',
	'count'
];

array_push( $output, $header );

foreach( $termmeta as $term ) {	

	$row = [
		$term->term_taxonomy_id,
		$term->term_id,
		$term->taxonomy,
		$term->description,
		$term->parent,
		$term->count
	];

	array_push( $output, $row );

}

$list = $output;

$file_termmeta = __DIR__ . '\export\taxonomy.csv';

$fp = fopen( $file_termmeta, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/
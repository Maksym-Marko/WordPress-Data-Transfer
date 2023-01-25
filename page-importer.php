<?php

/**
 * You should run each stage separately to decrease server loading.
 * Users and usermeta table must be imported manually. Pay attention about wp prefix.
 * If wp prefixes on the websites are the same = no problem!
*/


global $wpdb;

$files_root = __DIR__ . '\import-csv\\'; //local
// $files_root = __DIR__ . "/import-csv/"; //live

/**
 * 
 * STAGE 1 (INSERT POSTS AND "OLD_POST_ID" TO POSTMETA TABLE)
 * 
 * 
*/
/*
$header = [];

$row_h = 1;

if (($handle = fopen( $files_root.'posts.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        if( $row_h <= 0 ) {
            break;
        }

        $header = $data;        

        $row_h--;
        
    }
    fclose($handle);
}

// create body
$body = [];
$row_b = 0;

if (($handle = fopen( $files_root.'posts.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        $row_b++;

        if( $row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $data as $key => $value ) {

            $tmp_data[$header[$key]] = $value;
        }
        
        array_push( $body, $tmp_data );

        // if( $row_b > 1 ) {
        //     break;
        // }
        
    }
    fclose($handle);
}

echo 'Number of posts: ';
var_dump(count($body));
echo '<br>';

// write posts
$i=1;
foreach ( $body as $value_ ) {

    // create postdata args
    $post_data = [];

    foreach ( $value_ as $key__ => $value__ ) {        

        if( $key__ == 'ID' ) {

            $post_data['meta_input'] = ['OLD_POST_ID' => $value__];
            continue;

        }

        $post_data[$key__] = $value__;

    }

    // insert post into db
    $post_id = wp_insert_post( wp_slash( $post_data ) );

    if( is_wp_error($post_id) ) {

        echo 'Error with post ' . $post_data['meta_input']['OLD_POST_ID'];
        echo '<br>';
        echo $post_id->get_error_message();
        echo '<br>';

    } else {

        echo 'Success for ' . $post_data['meta_input']['OLD_POST_ID'] . '. New Post ID = ' . $post_id . '<br>';

    }

    echo 'Iteration - ' . $i . '<br>';
    $i++;

}
*/

/**
 * 
 * STAGE 2 (INSERS ATTACHMENTS)
 * 
 * 
*/
/*
$header = [];

$row_h = 1;

if (($handle = fopen( $files_root.'attachments.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        if( $row_h <= 0 ) {
            break;
        }

        $header = $data;        

        $row_h--;
        
    }
    fclose($handle);
}

// create body
$body_att = [];
$row_b = 0;

if (($handle = fopen( $files_root.'attachments.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        $row_b++;

        if( $row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $data as $key => $value ) {

            $tmp_data[$header[$key]] = $value;
        }
        
        array_push( $body_att, $tmp_data );

        // if( $row_b > 2 ) {
        //     break;
        // }
        
    }
    fclose($handle);
}

echo 'Number of posts: ';
var_dump(count($body_att));
echo '<br>';

// write attachments
$i=1;
foreach ( $body_att as $value_ ) {

    // create postdata args
    $post_data = [];

    foreach ( $value_ as $key__ => $value__ ) {        

        if( $key__ == 'ID' ) {

            $post_data['meta_input'] = ['OLD_ATT_ID' => $value__];

            continue;

        }

        $post_data[$key__] = $value__;

    }

    // insert post into db
    $attachment_id = wp_insert_post( wp_slash( $post_data ) );

    if( is_wp_error($attachment_id) ) {

        echo 'Error with attachment ' . $post_data['meta_input']['OLD_ATT_ID'];
        echo '<br>';
        echo $attachment_id->get_error_message();
        echo '<br>';

    } else {

        echo 'Success for attachment ' . $post_data['meta_input']['OLD_ATT_ID'] . '. New attachment ID = ' . $attachment_id . '<br>';

    }

    echo 'Iteration - ' . $i . '<br>';
    $i++;

}
*/

/**
 * 
 * STAGE 3 (LINK POSTS WITH ATTACHMENTS. ADD POST_PARENT TO ATTACHMENTS)
 * 
 * 
*/
/*
$header = [];

$row_h = 1;

if (($handle = fopen( $files_root.'postmeta.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        if( $row_h <= 0 ) {
            break;
        }

        $header = $data;        

        $row_h--;
        
    }
    fclose($handle);
}

// create body
$body = [];
$row_b = 0;

if (($handle = fopen( $files_root.'postmeta.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        $row_b++;

        if( $row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $data as $key => $value ) {

            $tmp_data[$header[$key]] = $value;
        }
        
        array_push( $body, $tmp_data );
        
    }
    fclose($handle);
}

// write postmeta
$i=1;
foreach ( $body as $value_ ) {
    
    // if there is attachment
    if( $value_['meta_key'] !== '_thumbnail_id' ) continue;

    // old attachment_id
    $old_attachment_id = $value_['meta_value'];

    $old_post_id = $value_['post_id'];

    $new_post_row = $wpdb->get_row( "SELECT * FROM wp_postmeta WHERE
        meta_value = $old_post_id AND meta_key = 'OLD_POST_ID'
    " );

    if( $new_post_row !== NULL ) {

        $new_post_id = $new_post_row->post_id;

        // get attachments
        $att_results = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE
            meta_value = $old_attachment_id AND meta_key = 'OLD_ATT_ID'
        " );

        if( count( $att_results ) > 0 ) {

            foreach ( $att_results as $value ) {

                $result = add_post_meta( $new_post_id, '_thumbnail_id', $value->post_id );
                echo 'Added post meta between post ' . $new_post_id . ' and attachment '. $value->post_id . '. Result = ' . $result . '<br>';

                // rewrite post_parent of attachment
                $attachment_attrs = [
                    'ID'            => $value->post_id,
                    'post_parent'   => $new_post_id
                ];
                $attachment_id = wp_update_post( $attachment_attrs, true );

                if ( is_wp_error( $attachment_id ) ) {
                    echo $attachment_id->get_error_message();
                }
                else {
                    echo '"post_parent" column updated for attachment ' . $value->post_id . '. post_parent=' . $new_post_id . '<br>';
                }

                echo '<br>----------------------<br>';
            }

        }
        
    }

    echo 'Iteration - ' . $i . '<br>';
    $i++;

}
*/

/**
 * 
 * STAGE 4 (ADD _wp_attached_file AND _wp_attachment_metadata TO NEW ATTACHMENTS)
 * 
 * 
*/
/*
$header = [];

$row_h = 1;

if (($handle = fopen( $files_root.'postmeta.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        if( $row_h <= 0 ) {
            break;
        }

        $header = $data;        

        $row_h--;
        
    }
    fclose($handle);
}

// create body
$body = [];
$row_b = 0;

if (($handle = fopen( $files_root.'postmeta.csv', "r" )) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

        $row_b++;

        if( $row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $data as $key => $value ) {

            $tmp_data[$header[$key]] = $value;
        }
        
        array_push( $body, $tmp_data );
        
    }
    fclose($handle);
}

// write postmeta
$_wp_attachment_metadata_arr = [];
$_wp_attached_file_arr = [];
foreach ( $body as $value_ ) {

    // list of _wp_attachment_metadata
    if( $value_['meta_key'] == '_wp_attachment_metadata' ) {

        array_push( $_wp_attachment_metadata_arr, $value_ );

    }

    // list of _wp_attached_file
    if( $value_['meta_key'] == '_wp_attached_file' ) {

        array_push( $_wp_attached_file_arr, $value_ );

    }

}

// add _wp_attachment_metadata
foreach ( $_wp_attachment_metadata_arr as $value ) {

    $old_att_id = $value['post_id'];

    $new_att_results = $wpdb->get_row( "SELECT * FROM wp_postmeta WHERE
        meta_value = $old_att_id AND meta_key = 'OLD_ATT_ID'
    " );

    $new_att_id = $new_att_results->post_id;

    $u_a = maybe_unserialize($value['meta_value']);

    // add "full" array
    if( isset( $u_a['file'] ) ) {

        $path_info = pathinfo($u_a['file']);
        $mime = 'image/' . $path_info['extension'];

        if( ! isset( $u_a['sizes']['full'] ) ) {
            $u_a['sizes']['full'] = [
                'file' => $path_info['basename'],
                'width' => $u_a['width'],
                'height' => $u_a['height'],
                'mime-type' => $mime
            ];
        }
    
        if( ! isset( $u_a['sizes']['medium'] ) ) {
            $u_a['sizes']['medium'] = [
                'file' => $path_info['basename'],
                'width' => $u_a['width'],
                'height' => $u_a['height'],
                'mime-type' => $mime
            ];
        }        

    }

    $result = add_post_meta( $new_att_id, '_wp_attachment_metadata', $u_a );
    echo 'Added "_wp_attachment_metadata" to attachment ' . $new_att_id . '. Result = ' . $result . '<br>';
    
}


// add _wp_attached_file
foreach ( $_wp_attached_file_arr as $value ) {

    $old_att_id = $value['post_id'];

    $new_att_results = $wpdb->get_row( "SELECT * FROM wp_postmeta WHERE
        meta_value = $old_att_id AND meta_key = 'OLD_ATT_ID'
    " );

    $new_att_id = $new_att_results->post_id;
    $result = add_post_meta( $new_att_id, '_wp_attached_file', $value['meta_value'] );
    echo 'Added "_wp_attached_file" to attachment ' . $new_att_id . '. Result = ' . $result . '<br>';
    
}
*/

/**
 * 
 * STAGE 5 (ADD TERMS TO POSTS)
 * 
 * 
*/

/*
// taxonomy
$taxonomy_header = [];

$row_h = 1;

if (($taxonomy_handle = fopen( $files_root.'taxonomy.csv', "r" )) !== FALSE) {
    while (($taxonomy_data = fgetcsv($taxonomy_handle, 1000000, ",")) !== FALSE) {

        if( $row_h <= 0 ) {
            break;
        }

        $taxonomy_header = $taxonomy_data;        

        $row_h--;
        
    }
    fclose($taxonomy_handle);
}

// create taxonomy body
$taxonomy_body = [];
$row_b = 0;

if (($taxonomy_handle = fopen( $files_root.'taxonomy.csv', "r" )) !== FALSE) {
    while (($taxonomy_data = fgetcsv($taxonomy_handle, 1000000, ",")) !== FALSE) {

        $row_b++;

        if( $row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        if( $taxonomy_data[2] !== 'category' ) continue;

        foreach( $taxonomy_data as $key => $value ) {

            $tmp_data[$taxonomy_header[$key]] = $value;
        }

        array_push( $taxonomy_body, $tmp_data );     
        
    }
    fclose($taxonomy_handle);
}

// terms
$terms_header = [];

$terms_row_h = 1;

if (($terms_handle = fopen( $files_root.'terms.csv', "r" )) !== FALSE) {
    while (($terms_data = fgetcsv($terms_handle, 1000000, ",")) !== FALSE) {

        if( $terms_row_h <= 0 ) {
            break;
        }

        $terms_header = $terms_data;        

        $terms_row_h--;
        
    }
    fclose($terms_handle);
}

// create terms body
$terms_body = [];
$terms_row_b = 0;

if (($terms_handle = fopen( $files_root.'terms.csv', "r" )) !== FALSE) {
    while (($terms_data = fgetcsv($terms_handle, 1000000, ",")) !== FALSE) {

        $terms_row_b++;

        if( $terms_row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $terms_data as $key => $value ) {

            $tmp_data[$terms_header[$key]] = $value;
        }

        array_push( $terms_body, $tmp_data );     
        
    }
    fclose($terms_handle);
}

// term_relationships
$term_relationships_header = [];

$term_relationships_row_h = 1;

if (($term_relationships_handle = fopen( $files_root.'term_relationships.csv', "r" )) !== FALSE) {
    while (($term_relationships_data = fgetcsv($term_relationships_handle, 1000000, ",")) !== FALSE) {

        if( $term_relationships_row_h <= 0 ) {
            break;
        }

        $term_relationships_header = $term_relationships_data;        

        $term_relationships_row_h--;
        
    }
    fclose($term_relationships_handle);
}

// create term_relationships body
$term_relationships_body = [];
$term_relationships_row_b = 0;

if (($term_relationships_handle = fopen( $files_root.'term_relationships.csv', "r" )) !== FALSE) {
    while (($term_relationships_data = fgetcsv($term_relationships_handle, 1000000, ",")) !== FALSE) {

        $term_relationships_row_b++;

        if( $term_relationships_row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $term_relationships_data as $key => $value ) {

            $tmp_data[$term_relationships_header[$key]] = $value;
        }

        array_push( $term_relationships_body, $tmp_data );     
        
    }
    fclose($term_relationships_handle);
}
// echo '<pre>';
// var_dump( $term_relationships_body );
// echo '</pre>';

// $taxonomy_body
// $terms_body
// term_relationships_body
foreach ($taxonomy_body as $key => $value) {

    $term_id = $value['term_id'];

    foreach ($terms_body as $key_ => $value_) {

        if( $term_id !== $value_['term_id'] ) continue;
        if( $value_['slug'] == 'uncategorized' ) continue;

        $new_category = wp_insert_term( $value_['name'], 'category' ); // ['term_id], ['term_taxonomy_id]

        if( ! isset( $new_category['term_id'] ) ) {
            echo 'Something went wrong with <br>';
            var_dump($value_);
            echo '<br>';
            continue;
        }

        echo 'New category created. Result: <br>';
        var_dump($new_category);
        echo '<br>';
         
        foreach ( $term_relationships_body as $key__ => $value__) {

            if( $value__['term_taxonomy_id'] !== $value_['term_id'] ) continue;

            $old_post_id = $value__['object_id'];

            $post_meta_row = $wpdb->get_row( "
                SELECT * FROM wp_postmeta
                WHERE meta_value = $old_post_id
                AND meta_key = 'OLD_POST_ID'
            " );

            if( $post_meta_row !== NULL ) {

                $new_post_id = $post_meta_row->post_id;

                $ins_cat = wp_set_post_categories( $new_post_id, $new_category['term_id'], true );

                echo 'Post ' . $new_post_id . ' got the category: <br>';
                var_dump($ins_cat);
                echo '<br>';

            }            

        }
        

        
    }

}
*/


/**
 * 
 * STAGE 6 (REMOVE UNCATEGORIZED FROM "OLD" POSTS)
 * 
 * 
*/
/*
// term_relationships
$term_relationships_header = [];

$term_relationships_row_h = 1;

if (($term_relationships_handle = fopen( $files_root.'term_relationships.csv', "r" )) !== FALSE) {
    while (($term_relationships_data = fgetcsv($term_relationships_handle, 1000000, ",")) !== FALSE) {

        if( $term_relationships_row_h <= 0 ) {
            break;
        }

        $term_relationships_header = $term_relationships_data;        

        $term_relationships_row_h--;
        
    }
    fclose($term_relationships_handle);
}

// create term_relationships body
$term_relationships_body = [];
$term_relationships_row_b = 0;

if (($term_relationships_handle = fopen( $files_root.'term_relationships.csv', "r" )) !== FALSE) {
    while (($term_relationships_data = fgetcsv($term_relationships_handle, 1000000, ",")) !== FALSE) {

        $term_relationships_row_b++;

        if( $term_relationships_row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $term_relationships_data as $key => $value ) {

            $tmp_data[$term_relationships_header[$key]] = $value;
        }

        array_push( $term_relationships_body, $tmp_data );     
        
    }
    fclose($term_relationships_handle);
}

$prepare_cats = [];
foreach ( $term_relationships_body as $value ) {    

    if( isset( $prepare_cats[$value['object_id']] ) ) {

        array_push( $prepare_cats[$value['object_id']], $value['term_taxonomy_id'] );

    } else {

        $prepare_cats[$value['object_id']] = [$value['term_taxonomy_id']];

    }
    
}

foreach ( $prepare_cats as $key => $value ) {

    if( ! in_array( '1', $value ) ) {

        $old_post_id = $key;

        $post_meta_row = $wpdb->get_row( "
                SELECT * FROM wp_postmeta
                WHERE meta_value = $old_post_id
                AND meta_key = 'OLD_POST_ID'
            " );

        if( $post_meta_row !== NULL ) {

            $new_post_id = $post_meta_row->post_id;

            $r = wp_remove_object_terms( $new_post_id, 'uncategorized', 'category' );
            echo 'Removed "uncategorized" from ' . $new_post_id . '. Result: <br>';
            var_dump($r);
            echo '<br>';
            
        }
        
    }

}
*/

/**
 * 
 * STAGE 7 (MOVE COMMENTS)
 * 
 * 
*/
/*
// comments
$comments_header = [];

$comments_row_h = 1;

if (($comments_handle = fopen( $files_root.'comments.csv', "r" )) !== FALSE) {
    while (($comments_data = fgetcsv($comments_handle, 1000000, ",")) !== FALSE) {

        if( $comments_row_h <= 0 ) {
            break;
        }

        $comments_header = $comments_data;        

        $comments_row_h--;
        
    }
    fclose($comments_handle);
}

// create comments body
$comments_body = [];
$comments_row_b = 0;

if (($comments_handle = fopen( $files_root.'comments.csv', "r" )) !== FALSE) {
    while (($comments_data = fgetcsv($comments_handle, 1000000, ",")) !== FALSE) {

        $comments_row_b++;

        if( $comments_row_b == 1 ) {
            continue;
        }

        $tmp_data = [];

        foreach( $comments_data as $key => $value ) {

            $tmp_data[$comments_header[$key]] = $value;
        }

        array_push( $comments_body, $tmp_data );     
        
    }
    fclose($comments_handle);
}

foreach ( $comments_body as $value ) {

    $old_post_id = $value['comment_post_ID'];

    $post_meta_row = $wpdb->get_row( "
        SELECT * FROM wp_postmeta
        WHERE meta_value = $old_post_id
        AND meta_key = 'OLD_POST_ID'
    " );

    if( $post_meta_row !== NULL ) {

        $new_post_id = $post_meta_row->post_id;

        $comment_data = [
            'comment_post_ID'      => $new_post_id,
            'comment_author'       => $value['comment_author'],
            'comment_author_email' => $value['comment_author_email'],
            'comment_author_url'   => $value['comment_author_url'],
            'comment_content'      => $value['comment_content'],
            'comment_type'         => $value['comment_type'],
            'comment_parent'       => $value['comment_parent'],
            'user_id'              => $value['user_id'],
            'comment_author_IP'    => $value['comment_author_IP'],
            'comment_agent'        => $value['comment_agent'],
            'comment_date'         => $value['comment_date'],
            'comment_approved'     => $value['comment_approved'],
        ];
        
        $comment = wp_insert_comment( wp_slash($comment_data) );
        echo 'Added comment to post ' . $value['comment_post_ID'] . '. Comment ID = ' . $comment . '<br>';
        
    }

}
*/

/**
 * 
 * STAGE 8 (REMOVE OLD_POST_ID AND OLD_ATT_ID FROM WP_POSTMETA)
 * 
 * 
*/
/*
$extra_data_results = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE
    meta_key = 'OLD_POST_ID' OR meta_key = 'OLD_ATT_ID'
" );

foreach( $extra_data_results as $value ) {

    $removed = $wpdb->delete( 'wp_postmeta', [ 'meta_id' => $value->meta_id ] );
    
    echo 'Removed row from wp_postmeta where meta_key = ' . $value->meta_key . '. Result - ' . $removed . '<br>';
    
}
*/

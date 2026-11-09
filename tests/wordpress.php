<?php
// Focused checks run in an isolated WordPress installation.
$plugin = new MultiPostThumbnails(array('label' => 'Secondary', 'id' => 'secondary', 'post_type' => 'post'));
$post_id = wp_insert_post(array('post_title' => 'Test', 'post_status' => 'publish'));
if (is_wp_error($post_id) || !$post_id) throw new RuntimeException('Could not create post');
if ($plugin->get_meta_key() !== 'post_secondary_thumbnail_id') throw new RuntimeException('Wrong thumbnail metadata key');
update_post_meta($post_id, $plugin->get_meta_key(), 123);
if ((int) MultiPostThumbnails::get_post_thumbnail_id('post', 'secondary', $post_id) !== 123) throw new RuntimeException('Thumbnail metadata not returned');
if (MultiPostThumbnails::has_post_thumbnail('post', 'other', $post_id)) throw new RuntimeException('Unassigned thumbnail was reported');
echo "PASS thumbnail registration and metadata\n";

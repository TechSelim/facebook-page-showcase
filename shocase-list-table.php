<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Shocase_list_table extends  WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {

        parent::__construct([
            'singular' => __('Shocase', 'sp'), 
            'plural'   => __('Shocases', 'sp'), 
            'ajax'     => false 

        ]);
    }

    function get_columns()
    {
        $columns = array(
            'cb'            => 'CB',
            'name'          => 'Name',
            'phone'         => 'Phone',
            'email'         => 'Email',
            'page_link'     => 'Page Link',
            'is_approved'   => 'Status'
        );
        return $columns;
    }

    function prepare_items()
    {

        $pageNum = $this->get_pagenum();
        $perPage = 10;

        $columns = $this->get_columns();
        $this->set_pagination_args([
            'total_items' => $this->get_total_row(),
            'per_page'    => $perPage
        ]);

        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->get_facebook_showcase($pageNum, $perPage);
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'name':
            case 'phone':
            case 'email':
            case 'page_link':
            case 'is_approved':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    function column_name($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a onclick="'. 'return confirm("Are you sure want to delete?")'.'" href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions));
    }
    function column_is_approved($item){
        if($item['is_approved'] == 1){
            return '<span style="color: green; "><b>Approved</b></span>';
        }else{
            return '<span style="color: #c5b038; "><b>Pending</b></span>';
        }
    }

    function get_facebook_showcase($offset, $perPage)
    {
        global $wpdb;
        $offset = ($offset - 1) * $perPage;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}facebook_pages ORDER BY id DESC limit $offset, $perPage", 'ARRAY_A');
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />',
            $item['ID']
        );
    }

    function get_total_row()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}facebook_pages");
    }
}

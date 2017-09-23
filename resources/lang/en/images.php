<?php

return [
    
    'index'  => [
        'all_title'       => 'All images',
        'title'           => 'My images',
        'delete_confirm'  => 'Are you sure you want to delete image with filename :filename ?',

        'button'    => [
            'delete'      => 'Delete',
        ],
        
        'table'     => [
            'id'         => 'ID',
            'filename'   => 'Filename',
            'path'       => 'Path',
            'user'       => 'User',
            'date'       => 'Date',
            'thumbnail'  => 'Thumbnail',
        ],
    ],
    
    'show'   => [
        'title'           => 'Image show',
        'delete_confirm'  => 'Are you sure you want to delete this image ?',

        'details'  => [
            'filename'    => 'Filename:',
            'folder'      => 'Folder:',
            'thumbnail'   => 'Thumbnail:',
            'user'        => 'User:',
            'created_at'  => 'Created At:',
        ],
        
        'button'   => [
            'delete'      => 'Delete Image',
            'to_gallery'  => 'Go to Image Gallery',
            'to_index'    => 'Go to Images index',
        ],
    ],
        
    'flash'  => [
        'deleted'  => 'Image has been deleted!',
    ]
    
];
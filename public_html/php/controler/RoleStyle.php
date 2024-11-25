<?php

function get_shadow_style_at_role($role){
    return 'box-shadow: 0px 0px 12px 2px ' . get_color_at_role($role);
}

function get_color_at_role($role){
    switch ($role) {
        case 'developer': return '#8E44AD';
        case 'chief_admin': return '#1ABC9C';
        case 'admin': return '#D98880';
        case 'moderator': return '#AF7AC5';
        case 'tester': return '#3498DB';
        case 'organization': return '#2ECC71';
        case 'premium': return '#F39C12';
        case 'user': return '#D5DBDB';
        case 'baned': return '#ff4040';
    }
}
?>
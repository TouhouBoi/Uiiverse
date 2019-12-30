<?php
// Main Index File

require_once("AltoRouter.php");

$router = new AltoRouter();

$router->addRoutes(
  array(
    array('GET|POST', '/', 'titleList.php', 'Title-list'),
    array('GET|POST', '/titles/[i:title_id]', 'list.php', 'Post-list'),
    array('GET|POST', '/titles/[i:title_id]/popular', 'popularPosts.php', 'Popular-posts'),
    array('GET|POST', '/posts/[i:id]', 'posts.php', 'Post-view'),
    array('GET|POST', '/replies/[i:id]', 'replies.php', 'Reply-view'),
    array('GET|POST', '/login', 'login.php', 'Login'),
    array('GET|POST', '/signup', 'signup.php', 'Signup'),
    array('GET|POST', '/logout', 'logout.php', 'Logout'),
    array('GET|POST', '/2fa', '2fa.php', '2FA'),
    array('GET|POST', '/enable-2fa', 'enable2FA.php', 'Enable 2FA'),
    array('GET|POST', '/disable-2fa', 'disable2FA.php', 'Disable 2FA'),
    array('GET|POST', '/change-email', 'changeEmail.php', 'Change-email'),
    array('GET|POST', '/settings/profile', 'settings.php', 'Settings'),
    array('GET|POST', '/guide/terms', 'terms.php', 'Terms'),
    array('GET|POST', '/guide/', 'rules.php', 'Rules'),
    array('GET|POST', '/guide/faq', 'faq.php', 'FAQ'),
    array('GET|POST', '/activity', 'activity.php', 'Activity-feed'),
    array('GET|POST', '/settings/account', 'account_settings.php', 'Account-settings'),
    array('GET|POST', '/settings/theme', 'theme_settings.php', 'Theme-settings'),
    array('GET|POST', '/admin_panel', 'admin/admin.php', 'Admin'),
    array('GET|POST', '/admin_panel/[*:action]', 'admin/admin.php', 'Admin-option'),
    array('GET|POST', '/activate/[*:code]', 'activate.php', 'Activate'),
    array('GET', '/users/[*:action]/posts', 'users.php', 'Users'),
    array('GET', '/users/[*:action]/yeahs', 'userYeahs.php', 'User-yeahs'),
    array('GET', '/users/[*:action]/', 'userDiary.php', 'User-profile'),
    array('GET', '/users/[*:action]/following', 'userFollowing.php', 'Following'),
    array('GET', '/users/[*:action]/followers', 'userFollowers.php', 'Followers'),
    array('GET', '/users/[*:action]/friends', 'userFriends.php', 'Friends'),
    array('GET', '/communities/favorites', 'favorites.php', 'Your-Favorites'),
    array('GET', '/my_blacklist', 'blacklist.php', 'Blocked-Users'),
    array('GET', '/users/[*:action]/favorites', 'favorites.php', 'Favorites'),
    array('GET', '/titles/search', 'searchTitles.php', 'Search-titles'),
    array('GET', '/communities/categories/official', 'allOfficialTitles.php', 'All-Official-Titles'),
    array('GET', '/communities/categories/special_all', 'allSpecialTitles.php', 'All-Special-Titles'),
    array('GET', '/communities/categories/wiiu_all', 'allWiiUTitles.php', 'All-Wii-U-Titles'),
    array('GET', '/communities/categories/switch_all', 'allSwitchTitles.php', 'All-Switch-Titles'),
    array('GET', '/communities/categories/3ds_all', 'all3DSTitles.php', 'All-3DS-Titles'),
    array('GET', '/identified_user_posts', 'verifiedPosts.php', 'Verified-posts'),
    array('GET', '/news/my_news', 'notifs.php', 'Notifs'),
    array('GET', '/check_update.json', 'check_update.php', 'Check-update'),
    array('GET', '/users', 'searchUsers.php', 'Search-users'),
    array('GET', '/admin_messages', 'adminMessages.php', 'Admin-messages'),
    array('POST', '/yeah', 'yeah.php', 'Yeah'),
    array('POST', '/posts/[i:id]/replies', 'postReply.php', 'Comment'),
    array('POST', '/posts/[i:id]/image.set_profile_post', 'favoritePost.php', 'Favorite'),
    array('POST', '/settings/profile_post.unset.json', 'favoritePost.php', 'Unfavorite'),

    // Put other arrays here
    array('GET|POST', '/titles/[i:title_id]/topic', 'discussion-list.php', 'Open-discussions'),
    array('GET|POST', '/titles/[i:title_id]/artwork', 'drawing-list.php', 'Artwork'),
    array('GET|POST', '/titles/[i:title_id]/diary', 'diary-list.php', 'Community-diary'),
    array('GET|POST', '/forgot/', 'forgot.php', 'Forgot your Password?'),
    array('GET|POST', '/reset/[*:code]', 'reset.php', 'Reset-code'),
    array('GET|POST', '/reset/', 'reset.php', 'Reset'),

    // Discovery Server API
    array('GET', '/v1/endpoint', 'api/discovery/endpoint.php', 'Endpoint-index'),
    array('GET', '/v1/endpoint[*:type]', 'api/discovery/endpoint.php', 'Endpoint-handler')
  )
);

// Match the current request
$match = $router->match(urldecode($_SERVER['REQUEST_URI']));

if ($match)
{
    foreach ($match['params'] as &$param)
    {
        ${key($match['params'])} = $param;
    }

    require_once($match['target']);
}
else
{
    http_response_code(404);

    exit("<link rel='stylesheet' type='text/css' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'><link rel='icon' type='image/png' href='/assets/img/404_icon.png'><center><br><br><br><br><br><b><h1>4... Oh, 4...</h1></b><p>This page seems to not exist. Sorry!</p><a href='https://uiiverse.xyz/'><b>« Return to Uiiverse</b></a></center>");
}

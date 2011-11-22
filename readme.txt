Created by Benjamin Bixby
benjaminbixby.com
bixby1@mail.lcc.edu

This plugin will grab a single random member based on your parameters... they are as follows:

1) Use {exp:random_member parse="inward"} ... {/exp:random_member}
- This will query the EE database and return one random member_id from ALL MEMBER GROUPS *!!including admins!!* for use with the {exp:member} tag.

2) Use {exp:random_member groupid="5" parse="inward"} ... {/exp:random_member}
- This will query the EE database and return one random member_id from ONLY the "Members" group, which has a group_id of "5".  You can choose to add whatever group or groups (i.e. groupid="3|4|5") you have setup in your EE backend.

To use the plugin, follow this syntax:
--------------------------------------

{exp:random_member groupid="5" parse="inward"} {!-- start plugin --}

	{!-- ee member tag --}
	{exp:member:custom_profile_data member_id="{random_member}"} {!-- the "random_member" tag must be used here for the plugin to work correctly --}

        <p>{username}</p>

	{/exp:member:custom_profile_data}


{/exp:random_member} {!-- finish plugin --}

--------------------------------------

EE2 Member Documentation:
http://expressionengine.com/user_guide/modules/member/index.html#custom-profile-data-tag

I make use of the PHP function array_rand() to pull out a random member id... Unfortunately, array_rand() is not very "random"... so the basic functunality is there for now... it's just not as good as it should be (due to PHP's native random function not being that great), so you might refresh the page and get the same member you had before.  As I get better at PHP, I'll be able to update this and make it so that each template call truly produces a random result... Also, looking into handing off the "random" part to MySQL as it may handle it better than PHP.  I will look into it in the future, but for now, use this! As always, any feature requests, please contact me @ email or twitter.com/bixby_benjamin - Thanks!

/*----------------------------------------------------*/

Changelog

V 1.0.2
- Nov 22, 2011
Fixed bug where no member would return error
Fixed a bug where no member in group would return error
Added functunality for querying multiple groups

V 1.0.1
- Nov 18, 2011
Fixed a bug where array_rand() might return a value of "0".
Added the "groupid" parameter

V 1.0
- Nov 17, 2011
Released initial version
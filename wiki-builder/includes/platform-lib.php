<?php
define('MEMBERSHIP_TYPE', 'membershipType');
define('MEMBERSHIP_ID', 'membershipId');
define('DESTINY_MEMBERSHIP_ID', 'destinyMembershipId');
define('CLAN_MEMBERSHIP_TYPE', 'clanMembershipType');
define('CHARACTER_ID', 'characterId');
define('DEFINITIONS', 'definitions');
define('GROUP_ID', 'groupId');

$api_params = array(
	// JSONP Service
	'jsonpService.GetCurrentUser' => array('query' => array('e' => 'callback'), 'post' => array()),

	// User Service
	'UpdateUser' => array('query' => array('g' => 'postData'), 'post' => array(
		'about',
		'adultMode',
		'displayName',
		'emailAddress',
		'emailUsage',
		'locale',
		'localeInheritDefault',
		'profilePicture',
		'profileTheme',
		'showActivity',
		'showFacebookPublic',
		'showGamertagPublic',
		'showGroupMessaging',
		'showPsnPublic',
		'uniqueName'
	)),

	'GetBungieNetUserById' => array('query' => array('g' => MEMBERSHIP_ID), 'post' => array()),
	'GetUserAliases' => array('query' => array('i' => MEMBERSHIP_ID), 'post' => array()),
	'SearchUsers' => array('query' => array('i' => 'query'), 'post' => array()),
	'SearchUsersPaged' => array('query' => array('h' => 'searchTerm', 'i' => 'page'), 'post' => array()),
	'SearchUsersPagedV2' => array('query' => array('i' => 'searchTerm', 'j' => 'page', 'h' => 'h'), 'post' => array()),
	'GetConversationById' => array('query' => array('e' => 'conversationId'), 'post' => array()),
	'GetConversationWithMemberId' => array('query' => array('e' => 'memberId'), 'post' => array()),
	'GetRecentNotifications' => array('query' => array('e' => 'format'), 'post' => array()),
	'GetBungieAccount' => array('query' => array('f' => MEMBERSHIP_ID, 'e' => MEMBERSHIP_TYPE), 'post' => array()),
	'SetAcknowledged' => array('query' => array('f' => 'ackId'), 'post' => array()),

	// Message Service
	'ReviewInvitationDirect' => array('query' => array('f' => 'invitationId', 'e' => 'invitationResponseState'), 'post' => array()),
	'GetConversationsV5' => array('query' => array('h' => 'currentPage'), 'post' => array()),

	// Notification Service

	// Content Service

	// External Social Service

	// Survey Service

	// Forum Service
	'CreatePost' => array('query' => array(), 'post' => array(
		'body',
		'category',
		'groupId',
		'isGroupPrivate',
		'metadata',
		'parentPostId',
		'subTopicOverride',
		'subject',
		'urlLinkOrImage',

	)),
	'Poll' => array('query' => array('f' => 'topicId'), 'post' => array()),
	'GetPostAndParent' => array('query' => array('h' => 'childPostId'), 'post' => array()),
	'GetPostAndParentAwaitingApproval' => array('query' => array('h' => 'childPostId'), 'post' => array()),
	'GetPostsThreadedPaged' => array('query' => array('g' => 'parentPostId', 'n' => 'page', 'j' => 'pageSize', 'i' => 'replySize', 'f' => 'getParentPost', 'e' => 'rootThreadMode', 'k' => 'sortMode'), 'post' => array()),
	'GetPostsThreadedPagedFromChild' => array('query' => array('f' => 'childPostId', 'm' => 'page', 'i' => 'pageSize', 'h' => 'replySize', 'e' => 'rootThreadMode', 'j' => 'sortMode'), 'post' => array()),

	'GetTopicForContent' => array('query' => array('h' => 'contentId'), 'post' => array()),
	'GetTopicsPaged' => array('query' => array('l' => 'page', 'h' => 'pageSize', 'k' => 'group', 'm' => 'sort', 'g' => 'quickDate', 'e' => 'categoryFilter'), 'post' => array()),
	'GetTopicsPagedForAlliance' => array('query' => array('l' => 'page', 'h' => 'pageSize', 'k' => 'group', 'm' => 'sort', 'g' => 'quickDate', 'e' => 'categoryFilter'), 'post' => array()),
	'GetTopicsPagedSimple' => array('query' => array('j' => 'page', 'i' => 'group', 'k' => 'sort', 'e' => 'categoryFilter'), 'post' => array()),

	// Activity Service
	'GetFriendsPaged' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => 'currentPage'), 'post' => array()),
	'GetFollowersOfUser' => array('query' => array('i' => 'profileId'), 'post' => array()),

	// Group Service
	'ApproveAllPending' => array('query' => array('e' => GROUP_ID), 'post' => array('message')),
	'ApproveGroupMembership' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array()),
	'ApproveGroupMembershipV2' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array('message')),
	'ApprovePendingForList' => array('query' => array('e' => GROUP_ID), 'post' => array('message', 'membershipIds[]')),

	'BanMember' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array('comment', 'length')),

	'BreakAlliance' => array('query' => array('c' => GROUP_ID, 'e' => 'allyGroupId'), 'post' => array()),
	'BreakAlliances' => array('query' => array('e' => GROUP_ID), 'post' => array()),

	//'CreateGroup' => array('query' => array(), 'post' => array()),
	'CreateGroupV2' => array('query' => array(), 'post' => array(
		'name',
		'clanCallSign',
		'motto',
		'about',
		'theme',
		'tags',
		'avatarImageIndex',
		'isPublic',
		'membershipOption',
		'isPublicTopicAdminOnly',
		'isDefaultPostPublic',
		'clanMembershipTypes',
		'attributes',
		'allowChat',
		'locale',
		'clanReviewType',
		'clanName'
	)),
	'CreateMinimalGroup' => array('query' => array(), 'post' => array('groupName', 'groupAbout')),

	'DenyAllPending' => array('query' => array('e' => GROUP_ID), 'post' => array('message')),
	'DenyGroupMembership' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array()),
	'DenyGroupMembershipV2' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array('message')),
	'DenyPendingForList' => array('query' => array('e' => GROUP_ID), 'post' => array('message', 'membershipIds[]')),

	'DesignateClanFounderForMigration' => array('query' => array('g' => GROUP_ID, 'c' => MEMBERSHIP_ID, 'f' => CLAN_MEMBERSHIP_TYPE), 'post' => array()),

	'DisableClanForGroup' => array('query' => array('f' => GROUP_ID, 'e' => CLAN_MEMBERSHIP_TYPE), 'post' => array()),

	'DisbandAlliance' => array('query' => array('e' => GROUP_ID), 'post' => array()),

	'EditGroup' => array('query' => array('e' => GROUP_ID), 'post' => array()),
	'EditGroupV2' => array('query' => array('e' => GROUP_ID), 'post' => array(
		'name',
		'clanCallSign',
		'motto',
		'about',
		'theme',
		'tags',
		'avatarImageIndex',
		'chatSecurity',
		'allowChat',
		'membershipOptions',
		'homepage',
		'locale',
		'isPublic',
		//'membershipOption',
		'isPublicTopicAdminOnly',
		'defaultPublicity',
		'isDefaultPostPublic',
		'clanReviewType',
		'enableInvitationMessagingForAdmins',
		'clanName',
		'clanMembershipTypes',
		//#'attributes',
		//'allowChat',
		//'locale',
		//'clanReviewType',
		//'clanName'
	)),

	'EditGroupMembership' => array('query' => array('h' => GROUP_ID, 'f' => MEMBERSHIP_ID, 'g' => 'groupMembershipType'), 'post' => array()),

	'EnableClanForGroup' => array('query' => array('g' => GROUP_ID, 'e' => CLAN_MEMBERSHIP_TYPE), 'post' => array()),

	'FollowGroupsWithGroup' => array('query' => array('e' => GROUP_ID), 'post' => array()),
	'FollowGroupWithGroup' => array('query' => array('f' => GROUP_ID, 'c' => 'followGroupId'), 'post' => array()),

	'GetAdminsOfGroup' => array('query' => array('g' => GROUP_ID), 'post' => array()),
	'GetAdminsOfGroupV2' => array('query' => array('g' => GROUP_ID), 'post' => array()),

	//'GetAllGroupsForCurrentMember' => array('query' => array(), 'post' => array()),
	'GetAllGroupsForMember' => array('query' => array('f' => MEMBERSHIP_ID), 'post' => array()),

	'GetAlliedGroups' => array('query' => array('g' => GROUP_ID), 'post' => array()),

	//'GetAvailableAvatars' => array('query' => array(), 'post' => array()),
	//'GetAvailableThemes' => array('query' => array(), 'post' => array()),

	'GetBannedMembersOfGroup' => array('query' => array('g' => GROUP_ID), 'post' => array()),
	'GetBannedMembersOfGroupV2' => array('query' => array('g' => GROUP_ID), 'post' => array()),

	//'GetClanAttributeDefinitions' => array('query' => array(), 'post' => array()),

	//'GetDeletedGroupsForCurrentMember' => array('query' => array(), 'post' => array()),
	'GetFoundedGroupsForMember' => array('query' => array('f' => MEMBERSHIP_ID, 'g' => 'currentPage'), 'post' => array()),
	'GetGroup' => array('query' => array('f' => GROUP_ID), 'post' => array()),
	'GetGroupByName' => array('query' => array('f' => 'groupName'), 'post' => array()),
	'GetGroupsFollowedByGroup' => array('query' => array('d' => GROUP_ID, 'g' => 'currentPage'), 'post' => array()),
	'GetGroupsFollowingGroup' => array('query' => array('d' => GROUP_ID, 'g' => 'currentPage'), 'post' => array()),

	//'GetGroupTagSuggestions' => array('query' => array(), 'post' => array()),

	//'GetJoinedGroupsForCurrentMember' => array('query' => array(), 'post' => array()),
	'GetJoinedGroupsForCurrentMemberV2' => array('query' => array('f' => 'currentPage'), 'post' => array()),

	'GetJoinedGroupsForMember' => array('query' => array('f' => MEMBERSHIP_ID), 'post' => array()),
	'GetJoinedGroupsForMemberV2' => array('query' => array('f' => MEMBERSHIP_ID, 'g' => 'currentPage'), 'post' => array()),
	'GetJoinedGroupsForMemberV3' => array('query' => array('f' => MEMBERSHIP_ID, 'g' => 'currentPage'), 'post' => array()),

	'GetMembersOfClan' => array('query' => array('h' => GROUP_ID), 'post' => array()),

	'GetMembersOfGroup' => array('query' => array('i' => GROUP_ID), 'post' => array()),
	'GetMembersOfGroupV2' => array('query' => array('i' => GROUP_ID), 'post' => array()),
	'GetMembersOfGroupV3' => array('query' => array('j' => GROUP_ID), 'post' => array()),

	'GetPendingClanMemberships' => array('query' => array('g' => GROUP_ID, 'e' => CLAN_MEMBERSHIP_TYPE, 'f' => 'currentPage'), 'post' => array()),

	//'GetPendingGroupsForCurrentMember' => array('query' => array(), 'post' => array()),
	'GetPendingGroupsForCurrentMemberV2' => array('query' => array('f' => 'currentPage'), 'post' => array()),
	'GetPendingGroupsForMember' => array('query' => array('f' => MEMBERSHIP_ID), 'post' => array()),
	'GetPendingGroupsForMemberV2' => array('query' => array('f' => MEMBERSHIP_ID, 'g' => 'currentPage'), 'post' => array()),

	'GetPendingMemberships' => array('query' => array('g' => GROUP_ID), 'post' => array()),
	'GetPendingMembershipsV2' => array('query' => array('f' => GROUP_ID), 'post' => array()),

	//'GetRecommendedGroups' => array('query' => array(), 'post' => array()),

	'GroupSearch' => array('query' => array(), 'post' => array(
		'contents[searchValue]',
		'contents[searchType]',
		'creationDate',
		'currentPage',
		'groupMemberCountFilter',
		'itemsPerPage',
		'localeFilter',
		'membershipType',
		'sortBy',
		'tagText'
	)),

	'InviteClanMember' => array('query' => array('g' => GROUP_ID, 'c' => MEMBERSHIP_ID, 'f' => CLAN_MEMBERSHIP_TYPE), 'post' => array('title', 'message')),
	'InviteGroupMember' => array('query' => array('f' => GROUP_ID, 'c' => MEMBERSHIP_ID), 'post' => array('title', 'message')),
	'InviteManyToJoinAlliance' => array('query' => array('c' => GROUP_ID), 'post' => array('targetIds[]', 'messageContent[message]')),
	'InviteToJoinAlliance' => array('query' => array('c' => GROUP_ID, 'e' => 'allyGroupId'), 'post' => array()),

	'JoinClanForGroup' => array('query' => array('f' => GROUP_ID, 'e' => CLAN_MEMBERSHIP_TYPE), 'post' => array('message')),

	'KickMember' => array('query' => array('g' => GROUP_ID, 'f' => MEMBERSHIP_ID), 'post' => array()),

	'LeaveClanForGroup' => array('query' => array('f' => GROUP_ID, 'e' => CLAN_MEMBERSHIP_TYPE), 'post' => array()),

	'OverrideFounderAdmin' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_TYPE), 'post' => array()),

	'RefreshClanSettingsInDestiny' => array('query' => array('e' => CLAN_MEMBERSHIP_TYPE), 'post' => array()),

	'RequestGroupMembership' => array('query' => array('f' => GROUP_ID), 'post' => array()),
	'RequestGroupMembershipV2' => array('query' => array('f' => GROUP_ID), 'post' => array()),

	'RequestToJoinAlliance' => array('query' => array('e' => GROUP_ID, 'c' => 'allyGroupId'), 'post' => array()),

	'RescindGroupMembership' => array('query' => array('f' => GROUP_ID), 'post' => array()),

	'SetGroupAsAlliance' => array('query' => array('e' => GROUP_ID), 'post' => array()),

	'SetPrivacy' => array('query' => array('f' => GROUP_ID), 'post' => array()),

	'UnbanMember' => array('query' => array('f' => GROUP_ID, 'e' => MEMBERSHIP_ID), 'post' => array()),

	'UndeleteGroup' => array('query' => array('e' => GROUP_ID), 'post' => array()),

	'UnfollowAllGroupsWithGroup' => array('query' => array('d' => GROUP_ID), 'post' => array()),
	'UnfollowGroupsWithGroup' => array('query' => array('d' => GROUP_ID), 'post' => array()),
	'UnfollowGroupWithGroup' => array('query' => array('e' => GROUP_ID, 'c' => 'followGroupId'), 'post' => array()),

	// Ignore Service
	'IgnoreItem' => array('query' => array(), 'post' => array(
		'ignoredItemId',
		'ignoredItemType',
		'comment',
		'reason',
		'itemContextId',
		'itemContextType',
		'ModeratorRequest'
	)),

	// Game Service

	// Admin Service

	// Tokens Service
	'ClaimToken' => array('query' => array(), 'post' => array('redeemCode')),
	'ClaimAndApplyOnToken' => array('query' => array('e' => 'tokenType'), 'post' => array('redeemCode')),

	// Destiny Service
	'GetTriumphs' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID), 'post' => array()),
	'GetDestinyAccountSummary' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID), 'post' => array()),
	'GetDestinySingleDefinition' => array('query' => array('k' => 'definitionType', 'l' => 'definitionId', 'h' => DEFINITIONS), 'post' => array()),
	'SearchDestinyPlayer' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => 'displayName'), 'post' => array()),
	'GetAccount' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetVault' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => DEFINITIONS), 'post' => array()),
	'GetCharacterSummary' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetCharacter' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetCharacterInventory' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetItemDetail' => array('query' => array('g' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'i' => CHARACTER_ID, 'h' => DEFINITIONS, 'f' => 'itemInstanceId'), 'post' => array()),
	'GetCharacterActivities' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetCharacterProgression' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetAllVendorsForCurrentCharacter' => array('query' => array('e' => MEMBERSHIP_TYPE, 'g' => CHARACTER_ID, 'f' => DEFINITIONS), 'post' => array()),
	'GetVendorSummariesForCurrentCharacter' => array('query' => array('e' => MEMBERSHIP_TYPE, 'g' => CHARACTER_ID, 'f' => DEFINITIONS), 'post' => array()),
	'GetVendorForCurrentCharacter' => array('query' => array('e' => MEMBERSHIP_TYPE, 'g' => CHARACTER_ID, 'h' => 'vendorId', 'f' => DEFINITIONS), 'post' => array()),
	'GetVendorItemDetailForCurrentCharacter' => array('query' => array('f' => MEMBERSHIP_TYPE, 'h' => CHARACTER_ID, 'i' => 'vendorId', 'e' => 'itemId', 'g' => DEFINITIONS), 'post' => array()),
	'GetPublicAdvisors' => array('query' => array('h' => DEFINITIONS), 'post' => array()),
	'GetAdvisorsForCurrentCharacter' => array('query' => array('e' => MEMBERSHIP_TYPE, 'g' => CHARACTER_ID, 'f' => DEFINITIONS), 'post' => array()),
	'GetSpecialEventAdvisors' => array('query' => array('h' => DEFINITIONS), 'post' => array()),
	'TransferItem' => array('query' => array('g' => 'postData'), 'post' => array('membershipType', 'itemReferenceHash', 'itemId', 'stackSize', 'characterId', 'transferToVault')),

	'EquipItem' => array('query' => array('g' => 'postData'), 'post' => array('membershipType', 'itemId', 'characterId')),
	'EquipItems' => array('query' => array('g' => 'postData'), 'post' => array('membershipType', 'characterId', 'itemIds][')),
	'GetHistoricalStats' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'g' => CHARACTER_ID, 'i' => 'periodType', 'o' => 'modes', 'm' => 'groups', 'h' => 'monthstart', 'k' => 'monthend', 'j' => 'daystart', 'l' => 'dayend'), 'post' => array()),
	'GetHistoricalStatsForAccount' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'g' => 'groups'), 'post' => array()),
	'GetActivityHistory' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'l' => 'mode', 'j' => 'count', 'm' => 'page', 'g' => DEFINITIONS), 'post' => array()),
	'GetUniqueWeaponHistory' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetLeaderboards' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => 'modes'), 'post' => array()),
	'GetLeaderboardsForPsn' => array('query' => array('f' => 'modes', 'h' => 'code'), 'post' => array()),
	'GetLeaderboardsForCharacter' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'g' => CHARACTER_ID, 'i' => 'modes'), 'post' => array()),
	'GetPostGameCarnageReport' => array('query' => array('f' => 'activityInstanceId', 'e' => DEFINITIONS), 'post' => array()),
	'GetActivityBlob' => array('query' => array('e' => 'e'), 'post' => array()),
	'GetDestinyAggregateActivityStats' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetMembershipIdByDisplayName' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => 'displayName', 'g' => DEFINITIONS), 'post' => array()),
	'GetExcellenceBadges' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'g' => DEFINITIONS), 'post' => array()),
	'GetMyGrimoire' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => DEFINITIONS, 'g' => 'flavour', 'h' => 'single'), 'post' => array()),
	'GetGrimoireByMembership' => array('query' => array('e' => MEMBERSHIP_TYPE, 'f' => DESTINY_MEMBERSHIP_ID, 'g' => DEFINITIONS, 'h' => 'flavour', 'i' => 'single'), 'post' => array()),
	'GetDestinyExplorerItems' => array('query' => array('v' => 'count', 'l' => 'characterClass', 'x' => 'types', 't' => 'subtype', 'z' => 'name', 'w' => 'order', 'o' => 'orderstathash', 'r' => 'direction', 'u' => 'rarity', 's' => 'buckets', 'k' => 'bucketsortypes', 'i' => 'weaponPerformance', 'n' => 'impactEffects', 'h' => 'guardianAttributes', 'm' => 'lightAbilities', 'p' => 'damageTypes', 'j' => 'matchrandomsteps', 'q' => DEFINITIONS), 'post' => array()),
	'GetDestinyExplorerTalentNodeSteps' => array('query' => array('r' => 'page', 'o' => 'count', 'q' => 'name', 'n' => 'direction', 'i' => 'weaponPerformance', 'k' => 'impactEffects', 'h' => 'guardianAttributes', 'j' => 'lightAbilities', 'l' => 'damageTypes', 'm' => 'definitions'), 'post' => array()),

	'SetItemLockState' => array('query' => array(), 'post' => array('membershipType', 'itemId', 'characterId', 'state')),
	'SetQuestTrackedState' => array('query' => array(), 'post' => array('membershipType', 'membershipId', 'characterId', 'itemId', 'state')),

	'GetVaultSummary' => array('query' => array('e' => MEMBERSHIP_TYPE), 'post' => array()),
	'GetCharacterInventorySummary' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID), 'post' => array()),
	'GetAllItemsSummary' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID), 'post' => array()),
	'GetAccountSummary' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID), 'post' => array()),

	'GetPublicVendor' => array('query' => array('i' => 'vendorId'), 'post' => array()),
	'GetPublicVendorWithMetadata' => array('query' => array('i' => 'vendorId'), 'post' => array()),
	'GetVendorForCurrentCharacterWithMetadata' => array('query' => array('e' => MEMBERSHIP_TYPE, 'g' => CHARACTER_ID, 'h' => 'vendorId'), 'post' => array()),
	'GetVendorItemDetailForCurrentCharacterWithMetadata' => array('query' => array('f' => MEMBERSHIP_TYPE, 'h' => CHARACTER_ID, 'i' => 'vendorId', 'e' => 'itemId'), 'post' => array()),

	'GetBondAdvisors' => array('query' => array('h' => MEMBERSHIP_TYPE), 'post' => array()),

	'GetAdvisorsForCharacter' => array('query' => array('f' => MEMBERSHIP_TYPE, 'd' => DESTINY_MEMBERSHIP_ID, 'h' => CHARACTER_ID), 'post' => array()),

	// Core Service
);


// Download platform.lib.min.js
$lib_url = 'https://www.bungie.net/Scripts/platform.lib.min.js';
$ch = curl_init($lib_url);
curl_setopt_array($ch, array(
	CURLOPT_RETURNTRANSFER => true
));
$lib_data = curl_exec($ch);
curl_close($ch);


// Parse Services
preg_match_all('/a\.([a-zA-Z]+Service)=\{dataStore:\[\],(.*?)\}\)\(jQuery\);/im', $lib_data, $service_matches, PREG_SET_ORDER);

$services = array();

foreach($service_matches as $service_index => $service) {
	$key = $service[1];
	$name = str_replace('Jsonp', 'JSONP', ucfirst($key));
	$data = $service[2];

	$services[$name] = array('name' => $name, 'endpoints' => array());

	preg_match_all('/,([A-Z]+[a-zA-Z0-9]+):function\(([^\)]+)\)\{'.'(.*?)\.buildUrl\((.*?)\);.*?\.serviceLibrary\.([^\(]+)'./*'(.*)a\.buildUrl\((.*?)\);'.*/'/m', $data, $funcs, PREG_SET_ORDER);
	foreach($funcs as $func_index => $func) {
		$key2 = $func[1];
		$params = $func[2];
		$params2 = $func[3];
		$method = $func[5];

		$query = array();
		preg_match_all('/\.addParam\([a-z]+,"([^,]+)",([a-z]+)\)/m', $params2, $params3, PREG_SET_ORDER);
		foreach($params3 as $param) {
			$query[] = $param[1].'={'.$param[2].'}';
		}
		$query = implode('&', $query);

		$api = $func[4];
		$api = preg_replace('/encodeURIComponent\(([^\)]+)\)/i', '$1', $api);
		$api = preg_replace('/\),.*/i', '', $api);
		$api = preg_replace('/",([^,])/i', '|', $api);
		$api = preg_replace('/,(.*)/i', '', $api);
		$api = preg_replace('/"\+([^\+]+)\+"/i', '{$1}', $api);

		$api = str_replace('"/', '/', $api);

		$api_data = $api.str_replace('&', ',', preg_replace('/=\{[^\}]+\}/', '', $query));
		$api_param = false;
		if (isset($api_params[$key.'.'.$key2])) $api_param = $api_params[$key.'.'.$key2];
		else if (isset($api_params[$key2])) $api_param = $api_params[$key2];

		if ($api_param) {
			foreach($api_param['query'] as $param_key => $param_value) {
				$api_data = str_replace('{'.$param_key.'}', '{'.$param_value.'}', $api_data);
			}
		}

		$api_data = explode('|', $api_data);

		$services[$name]['endpoints'][$key2] = array(
			'name' => $key2,
			'method' => strtoupper($method),
			'endpoint' => $api_data[0],
			'params' => $api_data[1] ? explode(',', $api_data[1]) : array(),
			'post' => $api_param ? $api_param['post'] : array()
		);
	}
}


// Output Services
$encoded_services = json_encode($services, JSON_PRETTY_PRINT);
$has_changed = !file_exists(BUILDERPATH.'/data/endpoints.json') || file_get_contents(BUILDERPATH.'/data/endpoints.json') != $encoded_services;
if ($has_changed) {
	copy(BUILDERPATH.'/data/endpoints.json', BUILDERPATH.'/data/endpoints-changes.json');
	file_put_contents(BUILDERPATH.'/data/endpoints.json', $encoded_services);
}

echo '<h3>API Endpoints'.($has_changed ? ' (Updated)' : '').' <small>(<a href="/data/endpoints.json?'.filemtime(BUILDERPATH.'/data/endpoints.json').'" target="_blank">endpoints.json</a>)</small></h3>';
echo '<textarea readonly>'.$encoded_services.'</textarea>';


// Parse Enums
preg_match_all('/var a=\bGlobals\b;([^\)]+)\}\)\(\);/i', $lib_data, $enums_match, PREG_SET_ORDER);
$data = $enums_match[0][1];
$data = preg_replace('/a\.([^=]+)=/i', '"$1":', $data);
$data = preg_replace('/([A-Za-z0-9_]+)\:/i', '"$1":', $data);
$data = preg_replace('/\};/i', '},', $data);
$data = preg_replace('/Enums*/i', '', $data);
$enums = json_decode('{'.$data.'}');


// Output Enums
$encoded_enums = json_encode($enums, JSON_PRETTY_PRINT);
$has_changed = !file_exists(BUILDERPATH.'/data/enums.json') || file_get_contents(BUILDERPATH.'/data/enums.json') != $encoded_enums;
if ($has_changed) {
	copy(BUILDERPATH.'/data/enums.json', BUILDERPATH.'/data/enums-changes.json');
	file_put_contents(BUILDERPATH.'/data/enums.json', $encoded_enums);
}


echo '<h3>Enums'.($has_changed ? ' (Updated)' : '').' <small>(<a href="/data/enums.json?'.filemtime(BUILDERPATH.'/data/endpoints.json').'" target="_blank">enums.json</a>)</small></h3>';
echo '<textarea readonly>'.$encoded_enums.'</textarea>';
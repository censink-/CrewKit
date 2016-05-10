<?php

	$weapon = $list["WEAPON"];
						
	$weaponex = explode('-', $weapon);
	
	$weaponraw = $weaponex[0];
	$weaponfirst = strpos($weaponraw, "(");
	$weaponsecond = strpos($weaponraw, ")");
	$weapondurabilityraw = substr($weaponraw, $weaponfirst, $weaponsecond);
	$weapondurability = str_replace("(", "", $weapondurabilityraw);
	$weapondurability = str_replace(")", "", $weapondurability);
	$weaponname = str_replace($weapondurabilityraw, "", $weaponraw);

	if (count($weaponex) == 2) {
		$weaponenchants = $weaponex[1];
		$weaponenchants = str_replace(" ", "", $weaponenchants);
		$weaponenchants = str_replace("(", " ", $weaponenchants);
		$weaponenchants = str_replace(")", "", $weaponenchants);
		$weaponenchants = str_replace("1", "I", $weaponenchants);
		$weaponenchants = str_replace("2", "II", $weaponenchants);
		$weaponenchants = str_replace("3", "III", $weaponenchants);
		$weaponenchants = str_replace("4", "IV", $weaponenchants);
		$weaponenchants = str_replace("5", "V", $weaponenchants);
		$weaponenchants = str_replace(",", "<br>", $weaponenchants);
		$weaponenchants = str_replace("DURABILITY", "Unbreaking", $weaponenchants);
		$weaponenchants = str_replace("DAMAGE_ALL", "Sharpness", $weaponenchants);
		$weaponenchants = str_replace("DAMAGE_ARTHROPODS", "Bane of Arthropods", $weaponenchants);
		$weaponenchants = str_replace("DAMAGE_UNDEAD", "Smite", $weaponenchants);
		$weaponenchants = str_replace("LOOT_BONUS_MOBS", "Looting", $weaponenchants);
		$weaponenchants = str_replace("FIRE_ASPECT", "Fire Aspect", $weaponenchants);
		$weaponenchants = str_replace("ARROW_KNOCKBACK", "Punch", $weaponenchants);
		$weaponenchants = str_replace("ARROW_DAMAGE", "Power", $weaponenchants);
		$weaponenchants = str_replace("ARROW_FIRE", "Flame", $weaponenchants);
		$weaponenchants = str_replace("ARROW_INFINITE", "Infinity", $weaponenchants);
		$weaponenchants = str_replace("KNOCKBACK", "Knockback", $weaponenchants);
		if (!is_null($weaponenchants) && $weaponenchants != "" && $weaponenchants != " ") {
			$weaponenchants = "data-content=\"<img src='assets/images/textures/blocks/enchanting_table_side.png'></p><span class='text-muted'>" . $weaponenchants . "</span>\"";
		} else {
			$weaponenchants = "data-content=\"<img src='assets/images/textures/blocks/enchanting_table_side.png'></p><span class='text-danger'>No Enchantments!</span>\"";
		}

	} else {
		$weaponenchants = "data-content='" . $weaponname . "'";
	}

switch ($weaponname) {
	default:
		$weapon = "data-content='" . $weaponname . "'' data-title='Unspecified Weapon <img src=\"assets/images/sleepy.gif\">'>?</td>";
		break;
	case "AIR(":
		$weapon = "data-content='Nothing - ~/~'><img src='assets/images/fist.gif'></td>";
		break;
	case "ENDER_PEARL":
		$weapon = "data-content='Enderpearl'><img src='assets/images/textures/items/ender_pearl.png'></td>";
		break;
	case "COOKED_BEEF":
		$weapon = "data-content='Meatslap!'><img src='assets/images/textures/items/beef_cooked.png'></td>";
		break;
	case "POTION":
		$weapon = "data-content='Potion'><img src='assets/images/textures/items/potion_bottle_empty.png'></td>";
		break;
	case "DIAMOND_SWORD":
		$weapondurability = 1561 - $weapondurability . "/1561";
		$weapon = "data-title='Diamond Sword - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/diamond_sword.png'></td>";
		break;
	case "IRON_SWORD":
		$weapondurability = 250 - $weapondurability . "/250";
		$weapon = "data-title='Iron Sword - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/iron_sword.png'></td>";
		break;
	case "STONE_SWORD":
		$weapondurability = 131 - $weapondurability . "/131";
		$weapon = "data-title='Stone Sword - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/stone_sword.png'></td>";
		break;
	case "GOLD_SWORD":
		$weapondurability = 32 - $weapondurability . "/32";
		$weapon = "data-title='Golden Sword - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/gold_sword.png'></td>";
		break;
	case "WOOD_SWORD":
		$weapondurability = 59 - $weapondurability . "/59";
		$weapon = "data-title='Wooden Sword - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/wood_sword.png'></td>";
		break;
	case "BOW";
		$weapondurability = 384 - $weapondurability . "/384";
		$weapon = "data-title='Bow - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/bow_standby.png'></td>";
		break;
	case "DIAMOND_AXE":
		$weapondurability = 1561 - $weapondurability . "/1561";
		$weapon = "data-title='Diamond Axe - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/diamond_axe.png'></td>";
		break;
	case "IRON_AXE":
		$weapondurability = 250 - $weapondurability . "/250";
		$weapon = "data-title='Iron Axe - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/iron_Axe.png'></td>";
		break;
	case "STONE_AXE":
		$weapondurability = 131 - $weapondurability . "/131";
		$weapon = "data-title='Stone Axe - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/stone_Axe.png'></td>";
		break;
	case "GOLD_AXE":
		$weapondurability = 32 - $weapondurability . "/32";
		$weapon = "data-title='Golden Axe - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/gold_Axe.png'></td>";
		break;
	case "WOOD_AXE":
		$weapondurability = 59 - $weapondurability . "/59";
		$weapon = "data-title='Wooden Axe - " . $weapondurability . "' " . $weaponenchants . "><img src='assets/images/textures/items/wood_Axe.png'></td>";
		break;
}
$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-trigger='hover'" . $weapon;
?>
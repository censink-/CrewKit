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

if (!function_exists('getEnchantments'))
{
	function getEnchantments($weapon)
	{					
		$weaponex = explode('-', $weapon);
		
		if (count($weaponex) == 2)
		{
			$enchantments = explode(',', $weaponex[1]);
		
			$enchNames = array();
			$enchLevels = array();
			
			foreach ($enchantments as $enchantmentraw)
			{
				$enchantmentfirst = strpos($enchantmentraw, "(");
				$enchantmentsecond = strpos($enchantmentraw, ")");
				$enchantmentlevelraw = substr($enchantmentraw, $enchantmentfirst, $enchantmentsecond);
				$enchantmentlevel = str_replace("(", "", $enchantmentlevelraw);
				$enchantmentlevel = str_replace(")", "", $enchantmentlevel);
				$enchantmentname = str_replace($enchantmentlevelraw, "", $enchantmentraw);
				
				array_push($enchNames, $enchantmentname);
				array_push($enchLevels, $enchantmentlevel);
			}
			
			$string = "";
			
			if (count($enchNames) != 0)
			{
				for ($i = 0; $i < count($enchNames); $i++)
				{
					$enchName = $enchNames[$i];
					$enchLevel = $enchLevels[$i];
					
					switch ($enchLevel)
					{
						case "1":
							$enchLevel = "I";
							break;
						case "2":
							$enchLevel = "II";
							break;
						case "3":
							$enchLevel = "III";
							break;
						case "4":
							$enchLevel = "IV";
							break;
						case "5":
							$enchLevel = "V";
							break;
					}
					
					$string = $string . $enchName . " " . $enchLevel;
					
					if ($i != count($enchNames) - 1)
					{
						$string = $string . "<br>";
					}
				}
			}
			else
			{
				$string = "No Enchantments!";
			}
			
			return $string;
		}
	}
}

switch ($weaponname) {
							default:
								$weapon = "<td data-toggle='popover' data-container='body' data-placement='left' data-html='true' data-content='Unspecified Weapon <img src=\"assets/images/sleepy.gif\"> - X/X' data-trigger='hover'>?</td>";
								break;
							case "AIR":
								$weapon = "<td data-toggle='popover' data-container='body' data-placement='left' data-content='Nothing - ~/~' data-trigger='hover'><img src='assets/images/fist.gif'></td>";
								break;
							case "DIAMOND_SWORD":
								$weapondurability = 1561 - $weapondurability . "/1561";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Diamond Sword - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/diamond_sword.png'></td>";
								break;
							case "IRON_SWORD":
								$weapondurability = 250 - $weapondurability . "/250";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Iron Sword - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/iron_sword.png'></td>";
								break;
							case "STONE_SWORD":
								$weapondurability = 131 - $weapondurability . "/131";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Stone Sword - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/stone_sword.png'></td>";
								break;
							case "GOLD_SWORD":
								$weapondurability = 32 - $weapondurability . "/32";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Golden Sword - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/gold_sword.png'></td>";
								break;
							case "WOOD_SWORD":
								$weapondurability = 59 - $weapondurability . "/59";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Wooden Sword - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/wood_sword.png'></td>";
								break;
							case "BOW";
								$weapondurability = 384 - $weapondurability . "/384";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Bow - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/bow_standby.png'></td>";
								break;
							case "DIAMOND_AXE":
								$weapondurability = 1561 - $weapondurability . "/1561";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Diamond Axe - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/diamond_axe.png'></td>";
								break;
							case "IRON_AXE":
								$weapondurability = 250 - $weapondurability . "/250";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Iron Axe - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/iron_Axe.png'></td>";
								break;
							case "STONE_AXE":
								$weapondurability = 131 - $weapondurability . "/131";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Stone Axe - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/stone_Axe.png'></td>";
								break;
							case "GOLD_AXE":
								$weapondurability = 32 - $weapondurability . "/32";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Golden Axe - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/gold_Axe.png'></td>";
								break;
							case "WOOD_AXE":
								$weapondurability = 59 - $weapondurability . "/59";
								$weapon = "<td data-toggle='popover' data-container='body' data-html='true' data-placement='left' data-title='Wooden Axe - " . $weapondurability . "' data-content='" . getEnchantments($list["WEAPON"]) . "' data-trigger='hover'><img src='assets/images/textures/items/wood_Axe.png'></td>";
								break;
						}
?>
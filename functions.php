<?php
/**
 * @param $value
 * @return string
 */
function _filter_post($value)
{
  return htmlspecialchars(stripslashes(trim($value)), ENT_QUOTES);
}

/**
 * @param $value
 * @return string
 */
function _filter($value)
{
  return htmlspecialchars_decode(stripslashes($value), ENT_QUOTES);
}

/**
 * @param $arr
 * @return array
 */
function _filter_array($arr)
{
	$filtered_arr = [];
	foreach ($arr as $key => $value) {
		$filtered_arr[$key] = _filter_post($value);
	}
	return $filtered_arr;
}
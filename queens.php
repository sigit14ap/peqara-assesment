<?php

function queensAttack($n, $k, $r_q, $c_q, $obstacles) {
	
	$obstaclesLocation = array();
	foreach ($obstacles as $value) {
		$obstaclesLocation[$value[0]][$value[1]] = 1;
	}

	$total = right($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ left($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ up($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ down($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ upLeftCorner($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ upRightCorner($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ downLeftCorner($n, $k, $r_q, $c_q, $obstaclesLocation)
			+ downRightCorner($n, $k, $r_q, $c_q, $obstaclesLocation)
			;

    echo $total."\n";

	return $total;
}

function isConditionTrue($n, $k, $r_q, $c_q, $obstacles)
{
	if ($r_q < 1 || $r_q > $n) {
		return true;
	}	

	if ($c_q < 1 || $c_q > $n) {
		return true;
	}	

	if (isset($obstacles[$r_q][$c_q])) {
		return true;
	}
	return false;
}

function right($n, $k, $r_q, $c_q, $obstacles)
{
	$c_q++;
	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + right($n, $k, $r_q, $c_q, $obstacles);
}

function left($n, $k, $r_q, $c_q, $obstacles)
{
	$c_q--;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + left($n, $k, $r_q, $c_q, $obstacles);
}

function up($n, $k, $r_q, $c_q, $obstacles)
{
	$r_q++;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + up($n, $k, $r_q, $c_q, $obstacles);
}
function down($n, $k, $r_q, $c_q, $obstacles) 
{
	$r_q--;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + down($n, $k, $r_q, $c_q, $obstacles);
}


// All corner move
function upLeftCorner($n, $k, $r_q, $c_q, $obstacles) 
{
	$r_q--;
	$c_q--;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + upLeftCorner($n, $k, $r_q, $c_q, $obstacles);
}

function upRightCorner($n, $k, $r_q, $c_q, $obstacles) 
{
	$r_q--;
	$c_q++;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + upRightCorner($n, $k, $r_q, $c_q, $obstacles);
}

function downLeftCorner($n, $k, $r_q, $c_q, $obstacles) 
{
	$r_q++;
	$c_q--;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + downLeftCorner($n, $k, $r_q, $c_q, $obstacles);
}

function downRightCorner($n, $k, $r_q, $c_q, $obstacles) 
{
	$r_q++;
	$c_q++;

	if (isConditionTrue($n, $k, $r_q, $c_q, $obstacles)) {
		return 0;
	}

	return 1 + downRightCorner($n, $k, $r_q, $c_q, $obstacles);
}

$fptr = fopen("output-queens.txt", "w");

$stdin = fopen("php://stdin", "r");

fscanf($stdin, "%[^\n]", $nk_temp);
$nk = explode(' ', $nk_temp);

$n = intval($nk[0]);

$k = intval($nk[1]);

fscanf($stdin, "%[^\n]", $r_qC_q_temp);
$r_qC_q = explode(' ', $r_qC_q_temp);

$r_q = intval($r_qC_q[0]);

$c_q = intval($r_qC_q[1]);

$obstacles = array();

for ($i = 0; $i < $k; $i++) {
    fscanf($stdin, "%[^\n]", $obstacles_temp);
    $obstacles[] = array_map('intval', preg_split('/ /', $obstacles_temp, -1, PREG_SPLIT_NO_EMPTY));
}

$result = queensAttack($n, $k, $r_q, $c_q, $obstacles);

fwrite($fptr, $result . "\n");

fclose($stdin);
fclose($fptr);
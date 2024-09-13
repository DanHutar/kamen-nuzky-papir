<?php
session_start(); //začátek session - musí být vždy první

//výchozí nastavení - když klíč "tvojeBody" v poli session neexistuje tak je vše nula 
if (array_key_exists("tvojeBody", $_SESSION) == false) {
	$_SESSION["tvojeBody"] = 0;
	$_SESSION["pocitaceBody"] = 0;
	$_SESSION["remiza"] = 0;
}

$pocitacVybral = null;

//zpracování tlačítka "nova hra" které ukončí session a načte stránku znovu
if (array_key_exists("novaHra", $_GET)) {
	session_destroy(); //tímto ukončím session
	header("Location:?"); //tímto znovu načtu stránku a vynuluji body
}

//řešeni statistiky tvého výběru ...pro samotnou hru nepodstatné
if (array_key_exists("kamen", $_SESSION) == false) {
	$_SESSION["kamen"] = 0;
}
if (array_key_exists("nuzky", $_SESSION) == false) {
	$_SESSION["nuzky"] = 0;
}
if (array_key_exists("papir", $_SESSION) == false) {
	$_SESSION["papir"] = 0;
}

//řešeni statistiky výběru počítače ...pro samotnou hru nepodstatné
if (array_key_exists("pocitacKamen", $_SESSION) == false) {
	$_SESSION["pocitacKamen"] = 0;
	$_SESSION["pocitacNuzky"] = 0;
	$_SESSION["pocitacPapir"] = 0;
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<h1>Zahraj si kámen, nůžky, papír!</h1>
	<h2>Co si vybereš?</h2>

	<div id="moznosti">
		<form method="$_GET">
			<button name="kamen">Kámen</button>
			<button name="nuzky">Nůžky</button>
			<button name="papir">Pápír</button>
		</form>
	</div>
	<br>
	<div id="vybraneMoznosti">
		<?php
		if (array_key_exists("kamen", $_GET)) {
			echo "Vybral jsi <b>kámen</b><br>";

			$_SESSION["kamen"]++; //přičtení tvého výběru do statistiky..pro chod hry je to nepodstatné

			$pocitacVybral = rand(1, 3);

			if ($pocitacVybral == 1) {
				echo "Počítač vybral taky <b>kámen</b>....remíza, hraj znovu!<br>";
				$_SESSION["remiza"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacKamen"]++; //přičtení výběru počítače do statistiky 
			} elseif ($pocitacVybral == 2) {
				echo "Počítač vybral <b>nůžky</b>.... vyhrál jsi!<br>";
				$_SESSION["tvojeBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacNuzky"]++; //přičtení výběru počítače do statistiky 
			} else {
				echo "Počítač vybral <b>papír</b>.... prohrál jsi!<br>";
				$_SESSION["pocitaceBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacPapir"]++; //přičtení výběru počítače do statistiky 
			}
		}

		if (array_key_exists("nuzky", $_GET)) {
			echo "Vybral jsi <b>nůžky</b><br>";

			$_SESSION["nuzky"]++; //přičtení tvého výběru do statistiky..pro chod hry je to nepodstatné

			$pocitacVybral = rand(1, 3);

			if ($pocitacVybral == 1) {
				echo "Počítač vybral <b>kámen</b>....prohrál jsi!<br>";
				$_SESSION["pocitaceBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacKamen"]++; //přičtení výběru počítače do statistiky 
			} elseif ($pocitacVybral == 2) {
				echo "Počítač vybral <b>nůžky</b>....remíza, hraj znovu!<br>";
				$_SESSION["remiza"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacNuzky"]++; //přičtení výběru počítače do statistiky 
			} else {
				echo "Počítač vybral <b>papír</b>....vyhrál jsi!<br>";
				$_SESSION["tvojeBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacPapir"]++; //přičtení výběru počítače do statistiky 
			}
		}

		if (array_key_exists("papir", $_GET)) {
			echo "Vybral jsi <b>papír</b> <br>";

			$_SESSION["papir"]++; //přičtení tvého výběru do statistiky..pro chod hry je to nepodstatné

			$pocitacVybral = rand(1, 3);

			if ($pocitacVybral == 1) {
				echo "Počítač vybral <b>kámen</b>....vyhrál jsi!<br>";
				$_SESSION["tvojeBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacKamen"]++; //přičtení výběru počítače do statistiky 
			} elseif ($pocitacVybral == 2) {
				echo "Počítač vybral <b>nůžky</b>....prohrál jsi!<br>";
				$_SESSION["pocitaceBody"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacNuzky"]++; //přičtení výběru počítače do statistiky 
			} else {
				echo "Počítač vybral <b>papír</b>....remíza, hraj znovu!<br>";
				$_SESSION["remiza"]++; //přičtení do celkových výsledků
				$_SESSION["pocitacPapir"]++; //přičtení výběru počítače do statistiky 
			}
		}
		?>
	</div>

	<div id="vysledky">
		<?php
		echo "<br>";
		echo "Tvoje body: {$_SESSION["tvojeBody"]} <br>";
		echo "Počítače body: {$_SESSION["pocitaceBody"]} <br>";
		echo "Remíza padla: {$_SESSION["remiza"]} krát";
		?>
	</div>

	<br>
	<div id="novaHra">
		<form method='$_GET'>
			<button name='novaHra'>Nová hra</button>
		</form>
	</div>

	<br>

	<div id="statistika">
		<div id="tvojeStatistika">
			<p>Tvoje statistika - co jsi vybral</p>
			<?php
			echo "Kámen : {$_SESSION["kamen"]} krát <br>";
			echo "Nůžky : {$_SESSION["nuzky"]} krát<br>";
			echo "Papír : {$_SESSION["papir"]} krát<br>";
			?>
		</div>

		<br>

		<div id="pocitaceStatistika">
			<p>Počítače statistika - co vybral on</p>
			<?php
			echo "Kámen : {$_SESSION["pocitacKamen"]} krát <br>";
			echo "Nůžky : {$_SESSION["pocitacNuzky"]} krát<br>";
			echo "Papír : {$_SESSION["pocitacPapir"]} krát<br>";
			?>
		</div>
	</div>
</body>

</html>
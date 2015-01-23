<?php

if(!isset($_GET['rating'])){
	header('Location: results.php');
}

echo '<head>';
    echo ' <link rel="stylesheet" href="styles.css" type="text/css"> 
    <link href="bootstrap.min.css" rel="stylesheet">';
echo '</head>';
echo '<table class="table table-bordered">';
$rating = $_GET['rating'];
$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$password = 'ttrojan';


$pdo = new PDO("mysql:host=$host; dbname=$dbname",$user, $password);

$sql = "
	SELECT title, format_name, genre_name, rating_name
	FROM dvds
	INNER JOIN formats
	ON dvds.format_id = formats.id
	INNER JOIN genres
	ON dvds.genre_id = genres.id
	INNER JOIN ratings
	ON dvds.rating_id = ratings.id
	WHERE '$rating' = rating_name
";

$statement = $pdo->prepare($sql);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);
// var_dump($movies);

// foreach($songs as $song){
// 	echo "<div".$song['title']."</div>"; 
// 	echo "<br>";
// }

if(empty($movies)){
	echo "<div>Sorry, we cannot find the rating: $rating. Try another search <a href=index.php> here</a>.<div>";
}else{
	$count = count($movies);
	echo "<div>We have found $count titles matching rating: $rating. Try another search <a href=index.php>here</a>.</div><br>";
	echo"<tr>
		    <th>Title</th>
		    <th>Format</th>
		    <th>Genre</th> 
		    <th>Rating</th>
		</tr>";
}

?>


		
<?php foreach($movies as $movie) : ?>
		<tr>
		    <td><?php echo $movie->title ?></td>
		    <td><?php echo $movie->format_name ?></td> 
		    <td><?php echo $movie->genre_name ?></td>
		    <td>
		    	<a href="ratings.php?rating=<?php echo $movie->rating_name?>">
					<?php echo $movie->rating_name ?>
				</a>
			</td>
	  	</tr>
<?php endforeach ?>
</table>
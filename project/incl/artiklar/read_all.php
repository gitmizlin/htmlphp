<?php

// Path to the SQLite database file
$dbPath = dirname(__FILE__) . "/data/bmo.sqlite";

//
// Connect to the database
//
$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Display errors, but continue script

//
// Read from database
//
$stmt = $db->prepare('SELECT * FROM Article WHERE category = "article";');
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($res as $art): ?>
    <br>
    <div class="article_wrapper_2">
	  	<article id="article">
		    <h2><?php echo $art['title']; ?></h2>
			    <p><?php echo $art['author']; ?>, publicerad <?php echo $art['pubdate']; ?></p>
			    <p><?php echo $art['content']; ?></p>
	    </article>
    </div>
<?php endforeach; ?>

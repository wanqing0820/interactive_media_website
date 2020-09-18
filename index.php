<?php
include("includes/init.php");
$title = "Gallery";

$messages = array();

const MAX_FILE_SIZE = 100000000000000;

if (isset($_POST["submit_upload"])) {

  $upload_info = $_FILES["box_file"];
  $upload_desc = trim($_POST['description']);

  if ($upload_info['error'] == UPLOAD_ERR_OK) {
    $upload_name = basename($upload_info["name"]);

    $upload_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION));

    $sql = "INSERT INTO images (file_name, file_ext, description) VALUES (:filename, :extension, :description)";
    $params = array(
      ':filename' => $upload_name,
      ':extension' => $upload_ext,
      ':description' => $upload_desc,
    );

    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $file_id = $db->lastInsertId("id");
      $id_filename = 'uploads/images/' . $file_id . '.' . $upload_ext;

      if (move_uploaded_file($upload_info["tmp_name"], $id_filename)) {
      } else {
        array_push($messages, "Failed to upload file. ");
      }
    } else {
      array_push($messages, "Failed to upload file.");
    }
  } else {
    array_push($messages, "Failed to upload file. ");
  }

    $tag1 = filter_input(INPUT_POST, 'tag1', FILTER_SANITIZE_STRING);
    $sql = "INSERT INTO tags (name) VALUES (:name)";
    $params1 = array(
      ':name' => $tag1
    );

    $result1 = exec_sql_query($db, $sql, $params1);
    if ($result1) {
        $tag_id = $db->lastInsertId("id");
    }

    else{
      echo "error";
    }

    $sql = "INSERT INTO image_tag (image_id, tag_id) VALUES (:image_id, :tag_id)";
    $params2 = array(
      ':image_id' => $file_id,
      ':tag_id' => $tag_id
    );

    $result2 = exec_sql_query($db, $sql, $params2);

}

?>

<?php
if (isset($_POST["submit_delete1"])) {
  $imageID = filter_input(INPUT_POST, 'imageID', FILTER_SANITIZE_STRING);
  $params = array(
    ':imageID' => $imageID
  );
  $sql = "DELETE FROM images WHERE images.id = :imageID";
  $res1 =exec_sql_query($db, $sql, $params)->fetchAll();
  $sql1 = "DELETE FROM image_tag WHERE image_tag.image_id = :imageID";
  $res2 = exec_sql_query($db, $sql1, $params)->fetchAll();

  $ptr = 'uploads/images/' . $imageID . '.jpg';
  unlink($ptr);

}
  ?>

<?php
if (isset($_POST["submit_delete2"])) {
  $tag2 = filter_input(INPUT_POST, 'tag2', FILTER_SANITIZE_STRING);
  var_dump($tag2);
  $params = array(
    ':tag2' => $tag2
  );
  $sql = "DELETE FROM tags WHERE tags.name = :tag2";
  $res = exec_sql_query($db, $sql, $params);
  $sql1 = "DELETE FROM image_tag WHERE image_tag.tag_id= :tag2";
  $res3= exec_sql_query($db, $sql1, $params);


}
  ?>

    <?php

$search_fields = array();
foreach ($tags as $tag){
  $key = $tag["id"];
  $value = $tag["name"];

  $search_fields[$key] = $value;

}

  // if (isset($_GET['search'])) {
  //     $do_search = TRUE;

  // // Get the search terms
  //   $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
  //   $search = trim($search);
  // } else {
  // // No search provided, so set the product to query to NULL
  //   $do_search = FALSE;
  //   $search = NULL;
  // }

  //   if ($do_search) {
  //       $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
  //       $search = trim($search);
  //       $params = array(
  //         ':search' => $search
  //           );
  //       $sql = "SELECT * FROM images WHERE description LIKE '%' || :search || '%'";

  //   } else {
  //     // No shoe to query, so return everything!
  //     ?>
       <?php

  //     $sql = "SELECT * FROM images";
  //     $params = array();
  //   }

  $tags = exec_sql_query($db, "SELECT * from tags")->fetchAll(PDO::FETCH_ASSOC);

  $search_fields = array();
  foreach ($tags as $tag){
    $key = $tag["id"];
    $value = $tag["name"];

    $search_fields[$key] = $value;

  }

  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

  <title>image gallery</title>
</head>

<body>

<main>

<body>

<!--
    <form id="searchForm" action="index.php" method="get" novalidate>
      <input type="text" id = "search" name="search" placeholder= "What's on your mind today?" required />
      <button type="submit" class="searchButton">
        <i class="fa fa-search"></i>
     </button>
    </form> -->
    </div>




      <!--form-->
      <section id="container">
    <div class="form-text">
      <span></span>
        <h3> Curate Your Own Collection</h3><br>

        <form id="uploadFile" action="index.php" method="post" enctype="multipart/form-data">
      <!-- MAX_FILE_SIZE must precede the file input field -->
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

      <div class="input_fields">
        <input id="box_file" type="file" placeholder = "Files here" name="box_file">
        </div>

        <div class="input_fields">
          <input id="box_desc" class = "field1" name="description" placeholder = "Description" type="text"/>
        </div>

        <div class="input_fields">
          <input name="tag1" class= "field1" placeholder = "Tag 1" id="tag1" type="text" />
        </div>

        <div class="input_fields">
          <span></span>
            <input type="submit" class= "sub_btn" name = "submit_upload" id="submit" value="Add"/>
        </div>

      </form>

      </div>
      </section>



      <!--form-->
      <section id="container2">
    <div ="form-img">
    </div>
    <div class="form-text2">
      <span></span>
        <h3> Curate Your Own Collection </h3><br>

        <form id="deleteFile" action="index.php" method="post" enctype="multipart/form-data">

        <div class="input_fields">
          <input id="imageID" name="imageID" class="field" placeholder = "imageID" type="text"/>
        </div>
        <div class="input_fields">
          <span></span>
            <input type="submit" class ="delete_btn" name = "submit_delete1" id="submit" value="Delete"/>
        </div>

        <div class="input_fields">
          <input name="tag2" class = "field" placeholder = "Tag" id="tag2" type="text" />
        </div>

        <div class="input_fields">
          <span></span>
            <input type="submit" class ="delete_btn" name = "submit_delete2" id="submit" value="Delete"/>
        </div>

      </form>

      </div>
      </section>

      <div class="sContainer">
<form id="searchForm" action="index.php" method="get" novalidate>
    <select name="category">
    <option value="" disabled selected> Filter by tags </option>
        <?php foreach ($search_fields as $key => $value) {
        ?>
          <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
        <?php } ?>
      </select>
      <button type="submit" class="searchButton">
        <i class="fa fa-search"></i>
     </button>
</form>
      </div>


    <?php
    foreach ($messages as $message) {
      echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
    }
    ?>






  <?php

$tags = exec_sql_query($db, "SELECT * from tags")->fetchAll(PDO::FETCH_ASSOC);
$search_fields = array();
foreach ($tags as $tag){
  $key = $tag["id"];
  $value = $tag["name"];

  $search_fields[$key] = $value;

}

if (isset($_GET['category'])){
  $do_search1 = TRUE;
  $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
  if (in_array($category, array_values($search_fields))) {
    $search_field = $category;
  } else {

    array_push($messages, "Invalid category for search.");
    $do_search1 = FALSE;
  }
}

if ($do_search1){
    if ($search_field == "all") {
        $sql = "SELECT * FROM images";
    } else {
        // Search across the specified field

        // Be careful to filter $search_field above. If you're not careful, you can seriously break your database.

        foreach ($search_fields as $key => $value) {
          if ($search_field==$value) {
              $tag_id = $key;
          }
        }

        $params = array(
          ':tag' => $tag_id,
        );

        $sql = "SELECT * FROM images INNER JOIN image_tag ON image_tag.image_id=images.id WHERE image_tag.tag_id ==:tag";
    }
  } else {
    // return everything!
    ?>
    <?php

  $sql = "SELECT * FROM images";
  $params = array();
}

    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      // The query was successful, let's get the records.
      $records = $result->fetchAll();

      if (count($records) > 0) {
          // We have records to display ?>
          <?php
                if (count($records) > 0) {
                    $i=0;
                    foreach ($records as $record) {
                        $i++;
                        $image_id=$record["id"];
                        $params = array(
                          ':image_id' => $image_id,
                        );

                        if ($i%5===1) {
                            echo '<table class="imageContainer"><tr>';
                        }
                        echo '<td><a href="#small_box'.$record["id"].'"'.'class="button">';
                        echo '<img class = "image" src="/uploads/images/'.$record["id"]. '.' . $record["file_ext"] .'"/>';
                        echo 'No.'. $record["id"];
                        echo '</a></td>';

                        if ($i%5 === 0) {
                            echo '</tr></table>';
                        }
                    }
                } else {
                    echo 'error';
                } ?>

                <?php
                foreach ($records as $record) {
                  $image_id=$record["id"];
                  $params = array(
                    ':image_id' => $image_id,
                  );
                  $sql="SELECT * FROM tags INNER JOIN image_tag WHERE tags.id==image_tag.tag_id AND image_tag.image_id = :image_id";

                  $tags_info = exec_sql_query($db, $sql, $params);
                    echo'<div class="popUp" id="small_box'.$record["id"].'"'.'>';
                    echo'<a href="#" class="cancel">×</a>';
                    echo '<img class = "image" src="/uploads/images/'.$record["id"]. '.' . $record["file_ext"] .'"/>';
                    if($tags_info){
                      foreach ($tags_info as $tag){
                        echo '<div class =tag_box1>#'.$tag["name"].' & '.$record["description"].'</div>';
                      }
                  }
                  else{
                      echo 'None </div>';
                  }
                  echo '</div>';

                    echo '<div id="cover" >
                    </div>';
                }
      } else {
        // No results found
        echo "<p>Stay tuned! </p>";
      }
    }
    ?>


      <!--citations for all the images used on this page -->
      <div class="citation">
      <!-- Source: https://www.pexels.com/photo/woman-wearing-white-and-yellow-scoop-neck-mini-dress-884979/
 -->
      Source: <cite><a href="https://www.pexels.com/photo/woman-wearing-white-and-yellow-scoop-neck-mini-dress-884979/
"     >image2</a></cite>

      <!-- Source: https://www.pexels.com/photo/woman-wearing-pink-overcoat-and-black-inner-top-2043590/ -->
      Source: <cite><a href="https://www.pexels.com/photo/woman-wearing-pink-overcoat-and-black-inner-top-2043590/">image3</a></cite>

      <!-- Source: https://www.pexels.com/search/fashion/ -->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image4</a></cite>

      <!-- Source: https://www.pexels.com/search/fashion/-->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image5</a></cite>


      <!-- Source: https://www.pexels.com/search/fashion/-->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image6</a></cite>


      <!-- Source: https://www.pexels.com/search/fashion/ -->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image7</a></cite>


      <!-- Source: https://www.pexels.com/search/fashion/ -->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image8</a></cite>


      <!-- Source: https://www.pexels.com/search/fashion/ -->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image9</a></cite>


      <!-- Source: https://www.pexels.com/search/fashion/-->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image10</a></cite>

      <!-- Source: https://www.pexels.com/search/fashion/-->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image11</a></cite>

      <!-- Source: https://www.pexels.com/search/fashion/ -->
      Source: <cite><a href="https://www.pexels.com/search/fashion/">image1</a></cite>

      </div>


  </main>
</body>

</html>

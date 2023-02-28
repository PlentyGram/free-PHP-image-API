<?php

// If form is submitted, get the keyword and search for related image
if (isset($_POST['submit'])) {
    $keyword = $_POST['keyword'];
    $search_url = "https://duckduckgo.com/?q=" . urlencode($keyword) . "&iar=images&iax=images&ia=images";
    $vqd = '';
    $img_url = '';
    $data = file_get_contents($search_url);
    if($data){
        preg_match("/vqd='(.*?)'/", $data, $matches);
        $vqd = $matches[1];
        $img_search_url = "https://duckduckgo.com/i.js?l=wt-wt&o=json&q=" . urlencode($keyword) . "&vqd=" . $vqd . "&f=,,,,,&p=1";
        $img_data = file_get_contents($img_search_url);
        if($img_data){
            $img_data = json_decode($img_data, true);
            $img_url = $img_data['results'][0]['image'];
        }
    }
}

?>

<!-- HTML form to allow user to enter keyword and submit -->
<form method="post">
    <label for="keyword">Enter keyword:</label>
    <input type="text" name="keyword" id="keyword">
    <input type="submit" name="submit" value="Submit">
</form>

<!-- Display image if one was found -->
<?php if (!empty($img_url)) { ?>
<div><p>url result:</p></div><code><?php echo $img_url; ?></code>
    <img width="60%" src="<?php echo $img_url; ?>" alt="<?php echo $keyword; ?>">
<?php } ?>
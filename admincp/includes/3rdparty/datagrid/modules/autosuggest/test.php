<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$aUsers = ["Ädams, Egbert", "Altman, Alisha", "Archibald, Janna", "Auman, Cody", "Bagley, Sheree", "Ballou, Wilmot", "Bard, Cassian", "Bash, Latanya", "Beail, May", "Black, Lux", "Bloise, India", "Blyant, Nora", "Bollinger, Carter", "Burns, Jaycob", "Carden, Preston", "Carter, Merrilyn", "Christner, Addie", "Churchill, Mirabelle", "Conkle, Erin", "Countryman, Abner", "Courtney, Edgar", "Cowher, Antony", "Craig, Charlie", "Cram, Zacharias", "Cressman, Ted", "Crissman, Annie", "Davis, Palmer", "Downing, Casimir", "Earl, Missie", "Eckert, Janele", "Eisenman, Briar", "Fitzgerald, Love", "Fleming, Sidney", "Fuchs, Bridger", "Fulton, Rosalynne", "Fye, Webster", "Geyer, Rylan", "Greene, Charis", "Greif, Jem", "Guest, Sarahjeanne", "Harper, Phyllida", "Hildyard, Erskine", "Hoenshell, Eulalia", "Isaman, Lalo", "James, Diamond", "Jenkins, Merrill", "Jube, Bennett", "Kava, Marianne", "Kern, Linda", "Klockman, Jenifer", "Lacon, Quincy", "Laurenzi, Leland", "Leichter, Jeane", "Leslie, Kerrie", "Lester, Noah", "Llora, Roxana", "Lombardi, Polly", "Lowstetter, Louisa", "Mays, Emery", "Mccullough, Bernadine", "Mckinnon, Kristie", "Meyers, Hector", "Monahan, Penelope", "Mull, Kaelea", "Newbiggin, Osmond", "Nickolson, Alfreda", "Pawle, Jacki", "Paynter, Nerissa", "Pinney, Wilkie", "Pratt, Ricky", "Putnam, Stephanie", "Ream, Terrence", "Rumbaugh, Noelle", "Ryals, Titania", "Saylor, Lenora", "Schofield, Denice", "Schuck, John", "Scott, Clover", "Smith, Estella", "Smothers, Matthew", "Stainforth, Maurene", "Stephenson, Phillipa", "Stewart, Hyram", "Stough, Gussie", "Strickland, Temple", "Sullivan, Gertie", "Swink, Stefanie", "Tavoularis, Terance", "Taylor, Kizzy", "Thigpen, Alwyn", "Treeby, Jim", "Trevithick, Jayme", "Waldron, Ashley", "Wheeler, Bysshe", "Whishaw, Dodie", "Whitehead, Jericho", "Wilks, Debby", "Wire, Tallulah", "Woodworth, Alexandria", "Zaun, Jillie"];
$aInfo = ["Bedfordshire", "Buckinghamshire", "Cambridgeshire", "Cheshire", "Cornwall", "Cumbria", "Derbyshire", "Devon", "Dorset", "Durham", "East Sussex", "Essex", "Gloucestershire", "Hampshire", "Hertfordshire", "Kent", "Lancashire", "Leicestershire", "Lincolnshire", "Norfolk", "Northamptonshire", "Northumberland", "North Yorkshire", "Nottinghamshire", "Oxfordshire", "Shropshire", "Somerset", "Staffordshire", "Suffolk", "Surrey", "Warwickshire", "West Sussex", "Wiltshire", "Worcestershire", "Durham", "East Sussex", "Essex", "Gloucestershire", "Hampshire", "Hertfordshire", "Kent", "Lancashire", "Leicestershire", "Lincolnshire", "Norfolk", "Northamptonshire", "Northumberland", "North Yorkshire", "Nottinghamshire", "Oxfordshire", "Shropshire", "Somerset", "Staffordshire", "Suffolk", "Surrey", "Warwickshire", "West Sussex", "Wiltshire", "Worcestershire", "Durham", "East Sussex", "Essex", "Gloucestershire", "Hampshire", "Hertfordshire", "Kent", "Lancashire", "Leicestershire", "Lincolnshire", "Norfolk", "Northamptonshire", "Northumberland", "North Yorkshire", "Nottinghamshire", "Oxfordshire", "Shropshire", "Somerset", "Staffordshire", "Suffolk", "Surrey", "Warwickshire", "West Sussex", "Wiltshire", "Worcestershire", "Durham", "East Sussex", "Essex", "Gloucestershire", "Hampshire", "Hertfordshire", "Kent", "Lancashire", "Leicestershire", "Lincolnshire", "Norfolk", "Northamptonshire", "Northumberland", "North Yorkshire", "Nottinghamshire"];
$input = strtolower($_GET["input"]);
$len = strlen($input);
$limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : 0;
$aResults = [];
$count = 0;
if ($len) {
    $i = 0;
    while ($i < count($aUsers)) {
        if (strtolower(substr(utf8_decode($aUsers[$i]), 0, $len)) == $input) {
            $count++;
            $aResults[] = ["id" => $i + 1, "value" => htmlspecialchars($aUsers[$i]), "info" => htmlspecialchars($aInfo[$i])];
        }
        
    }
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
if (1==1) {
    header("Content-Type: application/json");
    echo "{\"results\": [";
    $arr = [];
  
        $arr[] = "{\"id\": \"" . $aResults[$i]["id"] . "\", \"value\": \"" . $aResults[$i]["value"] . "\", \"info\": \"\"}";
    
    echo implode(", ", $arr);
    echo "]}";
} else {
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
    
        echo "<rs id=\"" . $aResults[$i]["id"] . "\" info=\"" . $aResults[$i]["info"] . "\">" . $aResults[$i]["value"] . "</rs>";
    
    echo "</results>";
}

?>